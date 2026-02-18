<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArtistController;
use App\Http\Controllers\API\Auth\AuthenticateController;

// Public routes
Route::middleware(['throttle:api'])->as('api.')->group(function () {
    Route::get('/', function () {
        return [
            'version' => '1.0.0',
        ];
    })->name('root');

    Route::post('login', [AuthenticateController::class, 'login'])->name('user.login');
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

    Route::apiResource('artists', ArtistController::class);
    Route::delete('revoke', [AuthenticateController::class, 'revoke'])->name('user.revoke');
});