<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceTokensController extends Controller
{
    protected $deviceTokenService;

    public function __construct(\App\Services\DeviceTokenService $deviceTokenService)
    {
        $this->deviceTokenService = $deviceTokenService;
    }

    // تُستدعى من الموبايل عند فتح التطبيق لحفظ التوكن
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        // رقم المستخدم في حال كان مسجل دخوله (وإلا سيكون null)
        $userId = auth('sanctum')->id(); 
        
        $this->deviceTokenService->storeToken($request->token, $userId);

        return response()->json(['message' => 'Token saved successfully']);
    }

    // تُستدعى عند تسجيل الخروج لمسح التوكن
    public function destroy(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $this->deviceTokenService->removeToken($request->token);

        return response()->json(['message' => 'Token removed successfully']);
    }
}
