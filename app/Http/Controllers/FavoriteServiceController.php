<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\FavoriteServiceService;

class FavoriteServiceController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteServiceService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    /**
     * Display a listing of the user's favorite services.
     */
    public function index()
    {
        $favorites = $this->favoriteService->getFavoriteServices();

        return response()->json([
            'message' => 'Favorite services retrieved successfully',
            'favorites' => $favorites
        ], 200);
    }

    /**
     * Add or remove a service from favorites.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id'
        ]);

        $result = $this->favoriteService->toggleFavorite((int) $request->service_id);

        return response()->json($result, 200);
    }
}
