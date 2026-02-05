<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreProfilePhoneRequest;
use App\Http\Requests\UpdateProfilePhoneRequest;
use App\Services\ProfilePhoneService;
class ProfilePhoneController extends Controller
{
    public function store(StoreProfilePhoneRequest $request,ProfilePhoneService $profilePhoneService)
    {
        $request->validate([
            'phone' => 'required|string|max:255',
        ]);

        $data = $request->validated();
        $profilePhoneService->create($data);
        return response()->json([
            'message' => 'تم اضافة رقم الهاتف بنجاح',
            'status' => 'success',
        ],200);
    }
    public function update(UpdateProfilePhoneRequest $request,ProfilePhoneService $profilePhoneService,$profile_phone_id)
    {
        

        $data = $request->validated();
        $profilePhoneService->update($data, $profile_phone_id);
        return response()->json([
            'message' => 'تم تحديث رقم الهاتف بنجاح',
            'status' => 'success',
        ],200);
    }
}
