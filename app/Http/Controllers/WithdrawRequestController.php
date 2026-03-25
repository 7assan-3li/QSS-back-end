<?php

namespace App\Http\Controllers;

use App\Services\WithdrawRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawRequestController extends Controller
{
    public function __construct(private WithdrawRequestService $service) {}

    // API: Provider sends a withdrawal request
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            $withdrawal = $this->service->store(Auth::id(), $request->amount);
            return response()->json([
                'message' => 'تم إرسال طلب السحب بنجاح وهو قيد المراجعة',
                'data' => $withdrawal
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    // API: Provider lists their own requests
    public function indexUser()
    {
        return response()->json([
            'data' => $this->service->indexUser(Auth::id())
        ]);
    }

    // Web Admin: List all requests
    public function indexWebAdmin(Request $request)
    {
        $withdrawals = $this->service->indexAdmin($request->status);
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    // Web Admin: Show single request
    public function showWebAdmin($id)
    {
        $withdrawal = \App\Models\WithdrawRequest::with(['user', 'admin'])->findOrFail($id);
        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    // Web Admin: Approve
    public function approveWebAdmin(Request $request, $id)
    {
        $request->validate([
            'bond_number' => 'required|string',
            'bond_image' => 'required|image|max:2048',
        ]);

        try {
            $this->service->approve($id, Auth::id(), $request->file('bond_image'), $request->bond_number);
            return redirect()->back()->with('success', 'تمت الموافقة على طلب السحب وتحويل المبلغ');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Web Admin: Reject
    public function rejectWebAdmin(Request $request, $id)
    {
        $request->validate(['admin_note' => 'required|string']);

        try {
            $this->service->reject($id, Auth::id(), $request->admin_note);
            return redirect()->back()->with('success', 'تم رفض طلب السحب');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
