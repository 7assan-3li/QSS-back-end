<?php

namespace App\Http\Controllers;

use App\constant\RequestStatus;
use App\Models\RequestBond;
use App\Models\Request as RequestModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestBondController extends Controller
{
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
            'description'  => 'nullable|string',
        ]);

        //التاكد من حالة الطلب
        $requestStatus = RequestModel::findOrFail($validated['request_id'])->status;
        if ($requestStatus !== RequestStatus::ACCEPTED_INITIAL && $requestStatus !== RequestStatus::ACCEPTED_PARTIAL_PAID) {
            return response()->json([
                'message' => 'لا يمكن رفع سند',
                'requestStatus'    => $requestStatus
            ], 422);
        }
        // return $requestStatus;
        // حفظ الصورة
        $path = $request->file('image_path')->store('bonds', 'public');

        $requestBond = RequestBond::create([
            'request_id'  => $validated['request_id'],
            'image_path'  => $path,
            'bond_number' => $validated['bond_number'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'message' => 'تم رفع السند بنجاح',
            'data'    => $requestBond
        ], 201);
    }
}
