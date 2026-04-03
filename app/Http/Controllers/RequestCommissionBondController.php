<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCommissionBondRequest;
use App\Models\RequestCommissionBond;
use App\Services\RequestCommissionBondService;
use Illuminate\Http\Request;

class RequestCommissionBondController extends Controller
{
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

    public function store(RequestCommissionBondRequest $request,RequestCommissionBondService $service)
    {
        $commissionBond = $service->create($request->validated());
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
        });

        return back()->with('success', 'تم قبول السند وتحديث رصيد العمولة');
    }

    public function reject(RequestCommissionBond $bond)
    {
        $bond->update(['status' => 'rejected']);
        return back()->with('success', 'تم رفض السند');
    }

    public function commissionSummary(Request $request)
    {
        $userId = $request->user()->id;

        $requests = \App\Models\Request::with(['user', 'main_service'])
            ->whereHas('main_service', function ($q) use ($userId) {
                $q->where('provider_id', $userId);
            })
            ->where(function($q) {
                $q->where('commission_amount', '>', 0)
                  ->orWhere('status', \App\constant\RequestStatus::COMPLETED);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $totalDue = $requests->sum('commission_amount');
        $totalPaid = $requests->sum('commission_amount_paid');
        $remaining = $totalDue - $totalPaid;

        return response()->json([
            'summary' => [
                'total_commission_due'  => $totalDue,
                'total_commission_paid' => $totalPaid,
                'remaining_balance'     => $remaining,
                'requests_count'        => $requests->count(),
            ],
            'details' => $requests->map(function ($req) {
                return [
                    'id'                     => $req->id,
                    'seeker_name'            => $req->user->name ?? 'N/A',
                    'total_price'            => $req->total_price,
                    'commission_amount'      => $req->getCommissionAmount(),
                    'commission_amount_paid' => $req->commission_amount_paid,
                    'commission_paid_status' => $req->commission_paid,
                    'created_at'             => $req->created_at->toDateTimeString(),
                    'status'                 => $req->status,
                ];
            }),
        ]);
    }
}
