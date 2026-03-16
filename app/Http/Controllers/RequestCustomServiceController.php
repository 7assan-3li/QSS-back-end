<?php

namespace App\Http\Controllers;

use App\Services\RequestCustomServiceService;
use Illuminate\Http\Request;

class RequestCustomServiceController extends Controller
{
    private $requestCustomServiceService;

    public function __construct(RequestCustomServiceService $requestCustomServiceService)
    {
        $this->requestCustomServiceService = $requestCustomServiceService;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'provider_id' => 'required|exists:users,id',
            'message' => 'required|string', // For custom services, message is usually required to describe requirements
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        try {
            $result = $this->requestCustomServiceService->store($data);

            return response()->json([
                'message' => 'تم إنشاء طلب الخدمة المخصصة بنجاح',
                'request_id' => $result['request_id']
            ], 201);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            if ($statusCode < 100 || $statusCode > 599) {
                $statusCode = 500;
            }
            return response()->json([
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    public function setPrice(Request $request, $id)
    {
        $data = $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        try {
            $this->requestCustomServiceService->setPrice((int)$id, $data['price']);

            return response()->json([
                'message' => 'تم تحديد السعر وتحديث حالة الطلب بنجاح',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'الطلب غير موجود'
            ], 404);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 500;
            if ($statusCode < 100 || $statusCode > 599) {
                $statusCode = 500;
            }
            return response()->json([
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }
}
