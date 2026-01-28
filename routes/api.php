<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArtistController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function () {
    return [
        'version' => '1.0.0',
        'success' => true,
    ];
})->middleware(['throttle:api']);

Route::apiResource('artists', ArtistController::class);
