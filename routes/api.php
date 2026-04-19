<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




require __DIR__ . '/api/auth.php';
require __DIR__ . '/api/users.php';
require __DIR__ . '/api/categories.php';
require __DIR__ . '/api/services.php';
require __DIR__ . '/api/requests.php';
require __DIR__ . '/api/request_bonds.php';
require __DIR__ . '/api/provider_requests.php';
require __DIR__ . '/api/request_complaints.php';
require __DIR__ . '/api/banks.php';
require __DIR__ . '/api/user_banks.php';
require __DIR__ . '/api/request_commission_bonds.php';
require __DIR__ . '/api/profiles.php';
require __DIR__ . '/api/profile_phones.php';
require __DIR__ . '/api/previousWork.php';
require __DIR__ . '/api/review.php';
require __DIR__ . '/api/verification_requests.php';
require __DIR__ . '/api/verification_packages.php';
require __DIR__ . '/api/user_verification_packages.php';
require __DIR__ . '/api/system_complaints.php';
require __DIR__ . '/api/points_packages.php';
require __DIR__ . '/api/withdrawals.php';
require __DIR__ . '/api/favorites.php';
require __DIR__ . '/api/finance.php';
require __DIR__ . '/api/policies.php';
require __DIR__ . '/api/social_auth.php';
require __DIR__ . '/api/notifications.php';
Route::get('/advertisements', [\App\Http\Controllers\AdvertisementController::class, 'getAds']);
Route::post('/advertisements/{advertisement}/click', [\App\Http\Controllers\AdvertisementController::class, 'trackClick']);
Route::post('/advertisements/{advertisement}/view', [\App\Http\Controllers\AdvertisementController::class, 'trackView']);
