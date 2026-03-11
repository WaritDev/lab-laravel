<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArtistController;
use App\Http\Controllers\API\Auth\AuthenticateController;
use App\Http\Controllers\API\PointController;
use App\Http\Controllers\API\DinnerPollController;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

// Public routes
Route::middleware(['throttle:api'])->as('api.')->group(function () {
    Route::get('/', function () {
        return [
            'version' => '1.0.0',
        ];
    })->name('root');

    Route::post('login', [AuthenticateController::class, 'login'])->name('user.login');
    Route::get('artists/recommended', [ArtistController::class, 'recommended'])->name('artists.recommended');
    Route::get('dinner-poll', [DinnerPollController::class, 'results'])->name('dinner-poll.results');
    Route::post('dinner-poll', [DinnerPollController::class, 'vote'])->name('dinner-poll.vote');
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
    Route::get('point', [PointController::class, 'show'])->name('points.show');
    Route::get('points', [PointController::class, 'index'])->name('points.index');
    Route::post('point', [PointController::class, 'earn'])->name('points.earn');
    Route::put('point', [PointController::class, 'redeem'])->name('points.redeem');
});