<?php

namespace App\Http\Controllers;

use App\constant\RequestStatus;
use App\Models\RequestComplaint;
use App\Models\Request as RequestModel;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $validated  = $request->validate([
            'title' => 'required|string|max:200',
            'type' => 'required|string|max:200',
            'content' => 'required|string|max:2000',
            'request_id'   => 'required|exists:requests,id',
        ]);

        $requestModel = RequestModel::findOrFail($request->request_id);
        $requestStatus = $requestModel->status;
        $provider = $requestModel->serviceProvider();

        if ($requestModel->user_id !== Auth::id() && (!$provider || $provider->id !== Auth::id())) {
            return response()->json([
                'message' => 'ليس لديك الصلاحية لارسال بلاغ على هذا الطلب'
            ], 403);
        }

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
            'user_id' => Auth::id(),
        ]);
        return response()->json([
                'message' => 'تم ارسال الشكوى بنجاح',
                'requestComplaint' => $requestComplaint
            ],201);
    }

    public function indexAdmin(\Illuminate\Http\Request $request)
    {
        $status = $request->get('status');
        $days = (int) $request->get('days', 7);

        $complaintsQuery = RequestComplaint::with('request.user')->latest();

        if ($status) {
            $complaintsQuery->where('status', $status);
        }

        $complaints = $complaintsQuery->get();

        // ===== Stats =====
        $stats = [
            'total' => RequestComplaint::count(),
            'pending' => RequestComplaint::where('status', 'pending')->count(),
            'in_progress' => RequestComplaint::where('status', 'in_progress')->count(),
            'completed' => RequestComplaint::where('status', 'resolved')->count(),
        ];

        // ===== Daily chart =====
        $labels = [];
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = $date;
            $data[] = RequestComplaint::whereDate('created_at', $date)->count();
        }

        return view('requestComplaints.index', compact(
            'complaints',
            'stats',
            'labels',
            'data',
            'days',
            'status'
        ));
    }

    public function showAdmin(RequestComplaint $requestComplaint)
    {
        $statusSteps = [
            'pending',
            'in_progress',
            'resolved',
        ];

        return view('requestComplaints.show', compact(
            'requestComplaint',
            'statusSteps'
        ));
    }

    public function updateStatus(\Illuminate\Http\Request $request, RequestComplaint $requestComplaint)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        $requestComplaint->update([
            'status' => $request->status,
            'admin_id' => Auth::id()
        ]);

        return back()->with('success', 'تم تحديث حالة الشكوى بنجاح');
    }
}
