<?php

namespace App\Services;
use App\Models\FavoriteService;
use Illuminate\Support\Facades\Auth;

class FavoriteServiceService
{
    /**
     * Toggle a service in user's favorites.
     */
    public function toggleFavorite(int $serviceId): array
    {
        $userId = Auth::id();

        $favorite = FavoriteService::where('user_id', $userId)
            ->where('service_id', $serviceId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return [
                'attached' => false,
                'message' => 'Service removed from favorites'
            ];
        }

        FavoriteService::create([
            'user_id' => $userId,
            'service_id' => $serviceId
        ]);

        return [
            'attached' => true,
            'message' => 'Service added to favorites'
        ];
    }

    /**
     * Get all favorite services for the authenticated user.
     */
    public function getFavoriteServices()
    {
        return Auth::user()->favoriteServices()
            ->with(['category', 'provider'])
            ->get();
    }
}
