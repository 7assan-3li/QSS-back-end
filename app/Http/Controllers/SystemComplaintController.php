<?php

namespace App\Http\Controllers;

use App\constant\SystemComplaintStatus;
use App\Http\Requests\StoreSystemComplaintRequest;
use App\Services\SystemComplaintService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SystemComplaint;
use Illuminate\Support\Facades\Auth;

class SystemComplaintController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $complaints = SystemComplaint::where('user_id', $user->id)->get();
        return response()->json([
            'message' => 'تم استرجاع الشكاوي بنجاح',
            'SystemComplaints' => $complaints,
        ], 200);
    }

    public function store(StoreSystemComplaintRequest $storeSystemComplaintRequest, SystemComplaintService $service)
    {
        $complaint = $service->create($storeSystemComplaintRequest->validated(), $storeSystemComplaintRequest);
        return response()->json([
            'message' => 'تم اضافة الشكوي بنجاح',
            'SystemComplaint' => $complaint,
        ], 201);
    }

    public function indexAdmin(Request $request)
    {
        $status = $request->get('status');
        $days = (int) $request->get('days', 7);

        $complaintsQuery = SystemComplaint::with('user')->latest();

        if ($status) {
            $complaintsQuery->where('status', $status);
        }

        $complaints = $complaintsQuery->get();

        // ===== Stats =====
        $stats = [
            'total' => SystemComplaint::count(),
            'pending' => SystemComplaint::where('status', SystemComplaintStatus::PENDING)->count(),
            'in_progress' => SystemComplaint::where('status', SystemComplaintStatus::IN_PROGRESS)->count(),
            'completed' => SystemComplaint::where('status', SystemComplaintStatus::COMPLETED)->count(),
        ];

        // ===== Daily chart =====
        $labels = [];
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = $date;

            $data[] = SystemComplaint::whereDate('created_at', $date)->count();
        }

        return view('systemComplaints.index', compact(
            'complaints',
            'stats',
            'labels',
            'data',
            'days',
            'status'
        ));
    }

    public function showAdmin(SystemComplaint $systemComplaint)
    {
        $statusSteps = [
            SystemComplaintStatus::PENDING,
            SystemComplaintStatus::IN_PROGRESS,
            SystemComplaintStatus::COMPLETED,
        ];

        $waitingHours = $systemComplaint->created_at
            ->diffInHours(
                $systemComplaint->status === SystemComplaintStatus::IN_PROGRESS ||
                $systemComplaint->status === SystemComplaintStatus::COMPLETED
                ? $systemComplaint->updated_at
                : now()
            );

        $processingHours = $systemComplaint->status === SystemComplaintStatus::COMPLETED
            ? $systemComplaint->updated_at->diffInHours($systemComplaint->created_at)
            : 0;

        return view('systemComplaints.show', compact(
            'systemComplaint',
            'statusSteps',
            'waitingHours',
            'processingHours'
        ));
    }

    public function updateStatus(Request $request, SystemComplaint $systemComplaint)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', SystemComplaintStatus::all()),
        ]);

        $systemComplaint->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'تم تحديث حالة الشكوى بنجاح');
    }
}