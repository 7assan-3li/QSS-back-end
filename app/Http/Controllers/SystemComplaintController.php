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
    public function index(Request $request)
    {
        $user = Auth::user();
        $source = $request->get('app_source'); // seeker or provider
        $status = $request->get('status');

        $query = SystemComplaint::with('user');

        // Check if user is admin (this depends on how roles are handled in your project)
        // Usually, admins have a specific role or permission.
        if ($user->role === 'admin') {
            if ($source) {
                $query->where('app_source', $source);
            }
        } else {
            $query->where('user_id', $user->id);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $complaints = $query->latest()->paginate(10);

        return response()->json([
            'message' => 'تم استرجاع الشكاوي بنجاح',
            'app_source' => $source,
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

        $complaints = $complaintsQuery->paginate(10);

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

    /**
     * Export detailed System Complaints to CSV.
     */
    public function exportDetailed(Request $request)
    {
        $status = $request->get('status');
        $query = SystemComplaint::with('user')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $complaints = $query->get();
        
        $filename = "qss_system_reports_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            __('كود البلاغ'), 
            __('العنوان'), 
            __('النوع'), 
            __('المصدر'), 
            __('صاحب البلاغ'), 
            __('الحالة'), 
            __('محتوى البلاغ'), 
            __('تاريخ التقديم')
        ];

        $callback = function() use($complaints, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns);

            foreach ($complaints as $c) {
                fputcsv($file, [
                    '#' . str_pad($c->id, 5, '0', STR_PAD_LEFT),
                    $c->title,
                    $c->type,
                    $c->app_source === 'provider' ? __('تطبيق المزود') : __('تطبيق العميل'),
                    $c->user->name ?? '---',
                    __($c->status),
                    $c->content,
                    $c->created_at->format('Y-m-d H:i')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}