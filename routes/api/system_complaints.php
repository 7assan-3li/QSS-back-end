<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SystemComplaintController;

Route::middleware(['auth:sanctum', 'verified','seeker.policy'])->group(function () {
    Route::get('/system-complaints', [SystemComplaintController::class, 'index'])->name('system-complaints.index');
    Route::post('/system-complaints', [SystemComplaintController::class, 'store'])->name('system-complaints.store');
    Route::get('/system-complaints/{systemComplaint}', [SystemComplaintController::class, 'show'])->name('system-complaints.show');
});