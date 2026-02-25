<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArtistController;
use App\Http\Controllers\API\Auth\AuthenticateController;
use App\Http\Controllers\API\PointController;

// Public routes
Route::middleware(['throttle:api'])->as('api.')->group(function () {
    Route::get('/', function () {
        return [
            'version' => '1.0.0',
        ];
    })->name('root');

    Route::post('login', [AuthenticateController::class, 'login'])->name('user.login');
    Route::get('artists/recommended', [ArtistController::class, 'recommended'])->name('artists.recommended');
});

// Protected routes
Route::middleware(['auth:sanctum', 'throttle:api'])->as('api.')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('me');
    
    Route::middleware(['ability:ADMIN'])->as('admin.')->group(function () {
        Route::get('/admin/dashboard', function (Request $request) {
            return response()->json(['message' => "Welcome {$request->user()->name} to the admin dashboard!"]);
        })->name('dashboard');
    });

    Route::put('artists/recommended', [ArtistController::class, 'updateRecommended'])->name('artists.updateRecommended');
    Route::apiResource('artists', ArtistController::class);
    Route::delete('revoke', [AuthenticateController::class, 'revoke'])->name('user.revoke');
    Route::get('points/total', [PointController::class, 'getTotalPoints'])->name('points.total');
    Route::post('points/earn', [PointController::class, 'earnPoints'])->name('points.earn');
    Route::post('points/redeem', [PointController::class, 'redeemPoints'])->name('points.redeem');
    Route::get('points/quarter/{year}/{quarter}', [PointController::class, 'getPointsByQuarter'])->name('points.byQuarter');
});