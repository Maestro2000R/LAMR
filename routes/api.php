<?php

use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\AssignmentController;
use App\Http\Controllers\Api\SiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/tokens', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
        'device_name' => 'required|string',
    ]);

    if (! Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
        return response()->json(['message' => 'Identifiants invalides.'], 422);
    }

    $user = Auth::user();

    return response()->json([
        'token' => $user->createToken($credentials['device_name'])->plainTextToken,
    ]);
});

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::apiResource('agents', AgentController::class);
    Route::apiResource('sites', SiteController::class);
    Route::apiResource('assignments', AssignmentController::class);
});
