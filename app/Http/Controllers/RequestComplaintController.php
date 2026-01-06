<?php

namespace App\Http\Controllers;

use App\constant\RequestStatus;
use App\Models\RequestComplaint;
use App\Models\Request as RequestModel;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class RequestComplaintController extends Controller
{

    // $table->string('title');
    //         $table->string('type');
    //         $table->text('content')->nullable();
    //         $table->string('status')->default('pending');
    //         $table->foreignId('request_id')->constrained('requests')->onDelete('cascade');
    //         $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
    public function store(Request $request)
    {
        $validate  = $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|string|max:200',
            'content' => 'required|string|max:2000',
            'request_id'   => 'required|exists:requests,id',
        ]);

        $requestModel = RequestModel::findOrFail($request->request_id);
        $requestStatus = $requestModel->status;

        if($requestStatus === RequestStatus::COMPLETED){
            return response()->json([
                'message' => 'لا يمكن ارسال بلاغ لان الطلب مكتمل',
                'requestStatus' => $requestStatus
            ],422);
        }

        $requestComplaint = RequestComplaint::create([
            'title' =>$request->title,
            'type' => $request->type,
            'content' => $request->content,
            'request_id' => $request->request_id,
        ]);
        return response()->json([
                'message' => 'تم ارسال الشكوى بنجاح',
                'requestComplaint' => $requestComplaint
            ],201);
    }
}
