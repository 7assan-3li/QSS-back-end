<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreProfilePhoneRequest;
use App\Http\Requests\UpdateProfilePhoneRequest;
use App\Services\ProfilePhoneService;
class ProfilePhoneController extends Controller
{
    public function index(ProfilePhoneService $profilePhoneService)
    {
        $phones = $profilePhoneService->index(auth()->user());
        return response()->json([
            'phones' => $phones,
            'message' => 'تم استرجاع أرقام الهاتف بنجاح',
        ], 200);
    }

    public function store(StoreProfilePhoneRequest $request, ProfilePhoneService $profilePhoneService)
    {
        $phone = $profilePhoneService->create($request->user(), $request->validated());

        return response()->json([
            'message' => 'تم إضافة رقم الهاتف بنجاح',
            'phone' => $phone,
        ], 201);
    }

    public function update(UpdateProfilePhoneRequest $request, ProfilePhoneService $profilePhoneService, $profile_phone_id)
    {
        $phone = $profilePhoneService->update($request->user(), $request->validated(), $profile_phone_id);

        return response()->json([
            'message' => 'تم تحديث رقم الهاتف بنجاح',
            'phone' => $phone,
        ], 200);
    }

    public function destroy(ProfilePhoneService $profilePhoneService, $profile_phone_id)
    {
        $profilePhoneService->delete(auth()->user(), $profile_phone_id);

        return response()->json([
            'message' => 'تم حذف رقم الهاتف بنجاح',
        ], 200);
    }
}
