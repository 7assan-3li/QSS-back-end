<?php

namespace App\Http\Controllers;

use App\constant\RequestStatus;
use App\constant\VerificationRequestStatus;
use App\Http\Requests\VerificationRequest\StoreVerificationRequestRequest;
use App\Models\RequestComplaint;
use App\Models\Service;
use App\Models\Request as RequestModel;
use App\Models\User;
use App\Models\VerificationRequest;
use App\Services\VerificationRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VerificationRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $verificationRequests = VerificationRequest::where('user_id', $user->id)->get();
        return response()->json([
            "message" => "تم استرجاع طلبات التحقق بنجاح",
            "verification_requests" => $verificationRequests
        ], 200);
    }
    public function store(StoreVerificationRequestRequest $verificationRequestRequest, VerificationRequestService $verificationRequestService)
    {
        $user = Auth::user();
        if ($user->verificationRequests()->where('status', VerificationRequestStatus::PENDING)->exists()) {
            return response()->json([
                "message" => "لا يمكن إرسال أكثر من طلب تحقق واحد",
            ], 400);
        }
        if ($user->verification_provider) {
            return response()->json([
                "message" => "تم قبولك كمزود خدمة موثق بالفعل",
            ], 400);
        }
        $verificationRequest = $verificationRequestService->create($verificationRequestRequest->validated());
        return response()->json([
            "message" => "تم إرسال طلب التحقق بنجاح",
            "verification_request" => $verificationRequest
        ], 201);
    }

    public function show($id)
    {
        $verificationRequest = VerificationRequest::find($id);
        if (!$verificationRequest) {
            return response()->json([
                "message" => "طلب التحقق غير موجود",
            ], 404);
        }
        return response()->json([
            "message" => "تم استرجاع طلب التحقق بنجاح",
            "verification_request" => $verificationRequest
        ], 200);
    }

    //wep functions
    public function indexAdmin(Request $request)
    {
        $days = $request->get('days', 7);

        $requests = VerificationRequest::with('user')
            ->latest()
            ->paginate(10);

        // ===== Stats =====
        $stats = [
            'total' => VerificationRequest::count(),
            'pending' => VerificationRequest::where('status', 'pending')->count(),
            'accepted' => VerificationRequest::where('status', 'accepted')->count(),
            'rejected' => VerificationRequest::where('status', 'rejected')->count(),
        ];

        // ===== Daily Chart =====
        $startDate = Carbon::now()->subDays($days - 1);
        $dates = collect();

        for ($i = 0; $i < $days; $i++) {
            $dates->push($startDate->copy()->addDays($i)->format('Y-m-d'));
        }

        $dailyData = VerificationRequest::whereDate('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $labels = $dates;
        $data = $dates->map(fn($date) => $dailyData[$date] ?? 0);

        return view('verificationRequests.index', compact(
            'requests',
            'stats',
            'labels',
            'data',
            'days'
        ));
    }

    public function acceptAdmin($id)
    {
        $request = VerificationRequest::findOrFail($id);
        $request->update(['status' => 'accepted']);
        $provider = $request->user();

        // التحقق مما إذا كانت هذه هي المرة الأولى التي يُقبل فيها توثيق هذا المزود
        $hasBeenVerifiedBefore = VerificationRequest::where('user_id', $provider->id)
            ->whereIn('status', [\App\constant\VerificationRequestStatus::ACCEPTED, \App\constant\VerificationRequestStatus::EXPIRED])
            ->where('id', '!=', $id) // استثناء الطلب الحالي
            ->exists();

        if (!$hasBeenVerifiedBefore) {
            $freeDays = \App\Models\Setting::where('key', 'initial_free_verification_days')->value('value') ?? 365;
            $provider->verification_provider = true;
            $provider->provider_verified_until = now()->addDays($freeDays);
            $provider->save();
            return back()->with('success', "تم قبول طلب التحقق وتوثيق مزود الخدمة ومنحه $freeDays يوم مجاني لأول مرة.");
        }

        // للمرات اللاحقة: منح فترة سماح قصيرة محددة من الإعدادات
        $graceDays = \App\Models\Setting::where('key', 'returning_free_verification_days')->value('value') ?? 0;
        
        if ($graceDays > 0) {
            $currentDate = $provider->provider_verified_until ? \Carbon\Carbon::parse($provider->provider_verified_until) : null;
            $startDate = ($currentDate && $currentDate->isFuture()) ? $currentDate : now();
            
            $provider->verification_provider = true;
            $provider->provider_verified_until = $startDate->addDays($graceDays);
            $provider->save();
            
            return back()->with('success', "تم قبول تحديث الهوية ومنح المزود فترة سماح قدرها $graceDays أيام إضافية للتفعيل.");
        }

        // إذا كانت فترة السماح 0، تُقبل هويته فقط، ولا يُعطى شارة التوثيق ولا تاريخ الصلاحية
        $provider->save();
        return back()->with('success', 'تم قبول الهوية. المزود كان موثقاً من قبل، لذا يجب عليه شراء باقة توثيق لتفعيل التوثيق في حسابه مجدداً.');
    }

    public function rejectAdmin($id)
    {
        $request = VerificationRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);
        $provider = $request->user();

        $provider->verification_provider = false;
        $provider->provider_verified_until = null;
        $provider->save();

        return back()->with('success', 'تم رفض طلب التحقق');
    }


    public function showAdmin(VerificationRequest $verificationRequest)
    {
        // مزود الخدمة
        $provider = User::findOrFail($verificationRequest->user_id);

        // الخدمات
        $servicesCount = Service::where('provider_id', $provider->id)->count();

        /*
        |--------------------------------------------------------------------------
        | الطلبات الخاصة بمزود الخدمة
        |--------------------------------------------------------------------------
        */

        // جميع الطلبات التي تحتوي على خدمات لهذا المزود
        $totalRequests = RequestModel::whereHas('services', function ($q) use ($provider) {
            $q->where('provider_id', $provider->id);
        })->count();

        // الطلبات المكتملة
        $completedRequests = RequestModel::whereHas('services', function ($q) use ($provider) {
            $q->where('provider_id', $provider->id);
        })->where('status', 'completed')->count();

        /*
        |--------------------------------------------------------------------------
        | العمولات غير المدفوعة
        |--------------------------------------------------------------------------
        */

        $unpaidCommissionRequests = RequestModel::whereHas('services', function ($q) use ($provider) {
            $q->where('provider_id', $provider->id);
        })
            ->where('status', RequestStatus::COMPLETED)
            ->orWhere('status', RequestStatus::ACCEPTED_FULL_PAID)
            ->orWhere('status', RequestStatus::ACCEPTED_PARTIAL_PAID)
            ->where('commission_paid', false)
            ->count();

        $totalCommission = RequestModel::whereHas('services', function ($q) use ($provider) {
            $q->where('provider_id', $provider->id);
        })
            ->where('status', 'completed')
            ->where('commission_paid', false)
            ->sum('total_price');

        $defaultCommission = \App\Models\Setting::where('key', 'provider_commission')->value('value') ?? 10;
        $percentage = $provider->commission ?? $defaultCommission;
        $totalCommission = $totalCommission * ($percentage / 100);

        /*
        |--------------------------------------------------------------------------
        | الشكاوى
        |--------------------------------------------------------------------------
        */

        $complaintsCount = RequestComplaint::whereHas('request.services', function ($q) use ($provider) {
            $q->where('provider_id', $provider->id);
        })->count();

        return view('verificationRequests.show', compact(
            'verificationRequest',
            'provider',
            'servicesCount',
            'totalRequests',
            'completedRequests',
            'unpaidCommissionRequests',
            'totalCommission',
            'complaintsCount'
        ));
    }


    // Cleaned up dead duplicated code.


}
