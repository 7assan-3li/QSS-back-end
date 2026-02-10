<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreviousWorkRequests\StorePreviousWorkRequest;
use App\Http\Requests\PreviousWorkRequests\UpdatePreviousWorkRequest;
use App\Services\PreviousWorkService;
use Illuminate\Support\Facades\Auth;
use App\Models\PreviousWork;
class PreviousWorkController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->profile) {
            return response()->json([
                'previousWorks' => [],
                'message' => 'User does not have a profile.'
            ], 200);
        }

        $previousWorks = PreviousWork::where('profile_id', $user->profile->id)->get();

        return response()->json([
            'previousWorks' => $previousWorks,
            'message' => 'Previous works retrieved successfully'
        ], 200);
    }

    public function store(StorePreviousWorkRequest $previousWorkRequest, PreviousWorkService $previousWorkService)
    {
        $previousWork = $previousWorkService->create($previousWorkRequest->validated(), $previousWorkRequest);
        return response()->json([
            'previousWork' => $previousWork,
            'message' => 'Previous work created successfully'
        ], 201);
    }

    public function show($previousWork_id)
    {
        $previousWork = PreviousWork::findOrFail($previousWork_id);

        return response()->json([
            'previousWork' => $previousWork,
            'message' => 'Previous work retrieved successfully'
        ], 200);
    }

    public function update(UpdatePreviousWorkRequest $updatePreviousWorkRequest, PreviousWorkService $previousWorkService, $previousWork_id)
    {
        $previousWork = $previousWorkService->update($updatePreviousWorkRequest->validated(), $updatePreviousWorkRequest, (int) $previousWork_id);
        return response()->json([
            'previousWork' => $previousWork,
            'message' => 'Previous work updated successfully'
        ], 200);
    }

    public function destroy(PreviousWorkService $previousWorkService, $previousWork_id)
    {
        $previousWorkService->delete((int) $previousWork_id);
        return response()->json([
            'message' => 'Previous work deleted successfully'
        ], 200);
    }
}
