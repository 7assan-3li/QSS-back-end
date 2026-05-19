<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCommissionBondRequest;
use App\Models\RequestCommissionBond;
use App\Models\Setting;
use App\constant\RequestStatus;
use App\Services\RequestCommissionBondService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestCommissionBondController extends Controller
{
    public function __construct(
        private \App\Services\NotificationService $notificationService
    ) {
    }
    public function index(Request $request)
    {
        $bonds = RequestCommissionBond::with('request.main_service')
            ->whereHas('request', function ($q) use ($request) {
                $q->whereHas('main_service', function ($sq) use ($request) {
                    $sq->where('provider_id', $request->user()->id);
                });
            })
            ->get();

        return response()->json($bonds);
    }

    public function store(RequestCommissionBondRequest $request, RequestCommissionBondService $service)
    {
        $commissionBond = $service->create($request->validated());

        // إشعار تأكيد استلام سند العمولة
        $this->notificationService->sendToUser(
            Auth::id(),
            'تم استلام سند العمولة 💸',
            'تم استلام سند دفع العمولة بنجاح وهو الآن قيد المراجعة من قبل الإدارة.',
            \App\Constants\NotificationType::ADMIN_MSG
        );

        return response()->json($commissionBond, 201);
    }


    //web functions
    public function approve(RequestCommissionBond $bond)
    {
        \DB::transaction(function () use ($bond) {
            $bond->update(['status' => 'approved']);

            $request = $bond->request;

            // تحديث المبلغ المقبوض كعمولة
            $request->commission_amount_paid += $bond->amount;

            // حساب المبلغ الإجمالي المطلوب للعمولة إذا لم يكن مسجلاً
            if ($request->commission_amount <= 0) {
                $request->commission_amount = $request->getCommissionAmount();
            }

            // تحديث حالة دفع العمولة
            if ($request->commission_amount_paid >= $request->commission_amount) {
                $request->commission_paid = true;
            }

            $request->save();

            // إشعار للمزود بقبول سند العمولة
            $this->notificationService->sendToUser(
                $request->serviceProvider()->id,
                'تم قبول سند العمولة ✅',
                'تم قبول سند دفع العمولة الخاص بالطلب #' . $request->id . ' بنجاح.',
                \App\Constants\NotificationType::ADMIN_MSG
            );

            // مسح الكاش الخاص بعدد العمولات غير المدفوعة ليتم فك الحظر إن وجد
            if ($provider = $request->serviceProvider()) {
                \Illuminate\Support\Facades\Cache::forget('unpaid_commissions_count_' . $provider->id);
            }
        });

        return back()->with('success', 'تم قبول السند وتحديث رصيد العمولة');
    }

    public function reject(Request $request, RequestCommissionBond $bond)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ], [
            'rejection_reason.required' => 'يجب كتابة سبب الرفض لتوضيحه للمزود.'
        ]);

        $bond->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        // إشعار للمزود برفض سند العمولة مع إرسال سبب الرفض
        $this->notificationService->sendToUser(
            $bond->request->serviceProvider()->id,
            'تم رفض سند العمولة ❌',
            'تم رفض سند دفع العمولة الخاص بالطلب #' . $bond->request->id . ' بسبب: ' . $request->rejection_reason,
            \App\Constants\NotificationType::ADMIN_MSG
        );

        return back()->with('success', 'تم رفض السند مع تسجيل سبب الرفض بنجاح.');
    }

    public function commissionSummary(Request $request)
    {
        $userId = $request->user()->id;

        // تحميل الطلبات مع العلاقة والمزود لتجنب N+1 queries
        $requests = \App\Models\Request::with(['user', 'main_service.provider'])
            ->whereHas('main_service', function ($q) use ($userId) {
                $q->where('provider_id', $userId);
            })
            ->where('status', RequestStatus::COMPLETED)
            ->orderBy('created_at', 'desc')
            ->get();

        // جلب الإعدادات مرة واحدة خارج الحلقة
        $defaultCommission = Setting::where('key', 'provider_commission')->value('value') ?? 10;

        $details = $requests->map(function (\App\Models\Request $req) use ($defaultCommission) {
            // الاستفادة من التحميل المسبق في النموذج
            $provider = $req->serviceProvider();
            $commissionAmount = $req->getCommissionAmount($provider, $defaultCommission);

            return [
                'id' => $req->id,
                'seeker_name' => $req->user->name ?? 'N/A',
                'total_price' => (float) $req->total_price,
                'commission_amount' => $commissionAmount,
                'commission_rate' => (float) $req->commission_rate,
                'commission_amount_paid' => (float) $req->commission_amount_paid,
                'commission_paid_status' => (bool) $req->commission_paid,
                'created_at' => $req->created_at->toDateTimeString(),
                'status' => $req->status,
            ];
        });

        $totalDue = $details->sum('commission_amount');
        $totalPaid = $details->sum('commission_amount_paid');
        $remaining = $totalDue - $totalPaid;

        return response()->json([
            'summary' => [
                'total_commission_due' => (float) $totalDue,
                'total_commission_paid' => (float) $totalPaid,
                'remaining_balance' => (float) $remaining,
                'requests_count' => $requests->count(),
            ],
            'details' => $details,
        ]);
    }

    public function indexAdmin(Request $request)
    {
        $status = $request->get('status');
        $query = RequestCommissionBond::with(['request.user', 'request.main_service.provider'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $bonds = $query->paginate(15);

        $stats = [
            'total' => RequestCommissionBond::count(),
            'pending' => RequestCommissionBond::where('status', 'pending')->count(),
            'approved' => RequestCommissionBond::where('status', 'approved')->count(),
            'total_amount' => RequestCommissionBond::where('status', 'approved')->sum('amount'),
        ];

        return view('admin.commissionBonds.index', compact('bonds', 'stats', 'status'));
    }
}
