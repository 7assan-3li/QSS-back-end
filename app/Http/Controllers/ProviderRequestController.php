<?php

namespace App\Http\Controllers;

use App\constant\providerRequestStatus;
use App\constant\Role;
use App\Models\ProviderRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderRequestController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', ProviderRequest::class);

        $providerRequests = ProviderRequest::where('user_id', Auth::id())->get();

        return response()->json($providerRequests);
    }

    public function store(Request $request)
    {
        $this->authorize('create', ProviderRequest::class);

        //  التحقق من وجود طلب اخر قيد الانتظار
        $hasPendingRequest = ProviderRequest::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingRequest) {
            return response()->json([
                'message' => 'لديك طلب قيد المراجعة بالفعل، لا يمكنك إرسال طلب جديد حالياً'
            ], 422);
        }

        $validated = $request->validate([
            'name'    => 'required|string|max:150',
            'location'    => 'required|string|max:150',
            'requestContent' => 'required|string|max:2000',
            'id_card' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        // رفع الصورة
        $validated['id_card'] = $request
            ->file('id_card')
            ->store('provider_requests/id_cards', 'public');

        // حفظ الطلب
        $providerRequest = ProviderRequest::create($validated);

        return response()->json([
            'message' => 'تم ارسال الطلب بنجاح',
            'providerRequest' => $providerRequest,
        ], 201);
    }

    public function show(ProviderRequest $providerRequest)
    {
        $this->authorize('view', $providerRequest);

        return response()->json($providerRequest);
    }

    public function destroy(ProviderRequest $providerRequest)
    {
        $this->authorize('delete', $providerRequest);

        $providerRequest->delete();

        return response()->json([
            'message' => 'تم حذف الطلب بنجاح',
        ]);
    }

    //admin functions
    public function adminIndex()
    {
        $this->authorize('adminViewAny', ProviderRequest::class);
        $requests = ProviderRequest::with(['user', 'admin'])
            ->latest()
            ->get();

        $stats = [
            'total' => ProviderRequest::count(),
            'pending' => ProviderRequest::where('status', providerRequestStatus::PENDING)->count(),
            'accepted' => ProviderRequest::where('status', providerRequestStatus::ACCEPTED)->count(),
            'rejected' => ProviderRequest::where('status', providerRequestStatus::REJECTED)->count(),
        ];

        return view('providerRequests.index', [
            'requests' => $requests,
            'stats' => $stats,
        ]);
    }

    public function adminShow(ProviderRequest $providerRequest)
    {
        $this->authorize('view', $providerRequest);

        $providerRequest->with(['user', 'admin']);
        // return $providerRequest;
        return view('providerRequests.show', [
            'providerRequest' => $providerRequest,
        ]);
    }

    public function updateStatus(Request $request, ProviderRequest $providerRequest)
    {
        $this->authorize('updateStatus', $providerRequest);

        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', ProviderRequestStatus::all()),
        ]);

        $currentStatus = $providerRequest->status;
        $newStatus = $validated['status'];

        $allowedTransitions = [
            ProviderRequestStatus::PENDING => [
                ProviderRequestStatus::REJECTED,
                ProviderRequestStatus::ACCEPTED,
            ],
        ];

        if (
            !isset($allowedTransitions[$currentStatus]) ||
            !in_array($newStatus, $allowedTransitions[$currentStatus])
        ) {
            return back()->withErrors('لا يمكن تغيير الحالة من هذه الحالة.');
        }

        $providerRequest->status = $newStatus;
        $providerRequest->admin_id = Auth::id();
        $providerRequest->save();

        if ($newStatus === ProviderRequestStatus::ACCEPTED) {
            $user = User::findOrFail($providerRequest->user_id);
            $user->role = Role::PROVIDER;
            $user->save();
        }

        return to_route('provider-requests.show', $providerRequest->id)->with('success', 'تم تحديث حالة الطلب بنجاح');
    }
}
