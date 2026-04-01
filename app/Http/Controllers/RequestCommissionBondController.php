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

}
