<?php

namespace App\Http\Controllers;

use App\constant\BondStatus;
use App\constant\RequestStatus;
use App\Models\RequestBond;
use App\Models\Request as RequestModel;
use App\Services\RequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestBondController extends Controller
{
    public function __construct(private RequestService $requestService)
    {
    }
    public function index()
    {
        $bonds = RequestBond::with('request')
            ->whereHas('request', fn($q) => $q->where('user_id', Auth::id()))
            ->get();

        return response()->json($bonds);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_id'   => 'required|exists:requests,id',
            'image_path'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bond_number'  => 'nullable|integer',
            'amount'       => 'required|numeric|min:0.01',
            'description'  => 'nullable|string',
        ]);

        //التاكد من حالة الطلب
        $requestModel = RequestModel::findOrFail($validated['request_id']);
        $requestStatus = $requestModel->status;
        
        if ($requestStatus !== RequestStatus::ACCEPTED_INITIAL && $requestStatus !== RequestStatus::ACCEPTED_PARTIAL_PAID) {
            return response()->json([
                'message' => 'لا يمكن رفع سند حالياً لهذا الطلب',
                'requestStatus'    => $requestStatus
            ], 422);
        }

        // حفظ الصورة
        $path = $request->file('image_path')->store('bonds', 'public');

        $requestBond = RequestBond::create([
            'request_id'  => $validated['request_id'],
            'image_path'  => $path,
            'bond_number' => $validated['bond_number'] ?? null,
            'amount'      => $validated['amount'],
            'description' => $validated['description'] ?? null,
            'status'      => BondStatus::PENDING,
        ]);

        return response()->json([
            'message' => 'تم رفع السند بنجاح وهو بانتظار المراجعة',
            'data'    => $requestBond
        ], 201);
    }

    public function approve($id)
    {
        return \DB::transaction(function () use ($id) {
            $bond = RequestBond::lockForUpdate()->findOrFail($id);
            
            if ($bond->status !== BondStatus::PENDING) {
                return response()->json(['message' => 'هذا السند غير موجود في حالة الانتظار'], 422);
            }

            $requestModel = RequestModel::lockForUpdate()->findOrFail($bond->request_id);

            // التحقق من أن المستخدم الحالي هو مزود الخدمة
            $provider = $requestModel->serviceProvider();
            if (!$provider || $provider->id !== Auth::id()) {
                return response()->json(['message' => 'غير مصرح لك بالموافقة على هذا السند، فقط مزود الخدمة يمكنه ذلك'], 403);
            }

            $bond->update(['status' => BondStatus::APPROVED]);
            // تحديث المبلغ المدفوع
            $requestModel = $this->requestService->addToMoneyPaid($requestModel->id, $bond->amount);

            if ($requestModel->money_paid >= $requestModel->total_price) {
                $requestModel->status = RequestStatus::ACCEPTED_FULL_PAID;
            } else {
                $requestModel->status = RequestStatus::ACCEPTED_PARTIAL_PAID;
            }

            $requestModel->save();

            return response()->json([
                'message' => 'تمت الموافقة على السند وتحديث حالة الطلب بنجاح',
                'bond' => $bond->load('request')
            ]);
        });
    }

    public function reject($id)
    {
        $bond = RequestBond::findOrFail($id);
        
        if ($bond->status !== BondStatus::PENDING) {
            return response()->json(['message' => 'هذا السند غير موجود في حالة الانتظار'], 422);
        }

        $requestModel = $bond->request;
        $provider = $requestModel->serviceProvider();
        if (!$provider || $provider->id !== Auth::id()) {
            return response()->json(['message' => 'غير مصرح لك برفض هذا السند، فقط مزود الخدمة يمكنه ذلك'], 403);
        }

        $bond->update(['status' => BondStatus::REJECTED]);

        return response()->json([
            'message' => 'تم رفض السند بنجاح',
            'bond' => $bond
        ]);
    }
}
