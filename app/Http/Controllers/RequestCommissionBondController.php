<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCommissionBondRequest;
use App\Models\RequestCommissionBond;
use App\Services\RequestCommissionBondService;
use Illuminate\Http\Request;

class RequestCommissionBondController extends Controller
{
    public function index()
    {}
    public function store(RequestCommissionBondRequest $request,RequestCommissionBondService $service)
    {
        $commissionBond = $service->create($request->validated());
        return response()->json($commissionBond, 201);
    }


    //web functions
    public function approve(RequestCommissionBond $bond)
    {
        $bond->update(['status' => 'approved']);
        return back()->with('success', 'تم قبول السند');
    }

    public function reject(RequestCommissionBond $bond)
    {
        $bond->update(['status' => 'rejected']);
        return back()->with('success', 'تم رفض السند');
    }

}
