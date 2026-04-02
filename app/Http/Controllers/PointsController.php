<?php

namespace App\Http\Controllers;

use App\Services\PointsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointsController extends Controller
{
    protected $pointsService;

    public function __construct(PointsService $pointsService)
    {
        $this->pointsService = $pointsService;
    }

    /**
     * Convert paid_points (earnings) to bonus_points with 1% incentive
     */
    public function convertPaidToBonus(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            $result = $this->pointsService->convertPaidToBonus(Auth::id(), $request->amount);

            return response()->json([
                'message' => 'تم تحويل الرصيد بنجاح مع حافز 1%',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
    public function indexTransactions(Request $request)
    {
        $transactions = \App\Models\PointTransaction::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'تم استرجاع حركة النقاط بنجاح',
            'data' => $transactions
        ]);
    }
    public function getPointsBalance(Request $request)
    {
        $userId = Auth::id();
        $points = $this->pointsService->getUserPoints($userId);

        return response()->json([
            'message' => 'تم استرجاع الرصيد بنجاح',
            'data' => $points
        ]);
    }
}
