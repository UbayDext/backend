<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PelajaranController;
use App\Http\Controllers\Api\ClassroomController;
use App\Http\Controllers\API\UserProfileController;
use App\Http\Controllers\API\AbsensiSiswaController;

Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::post('/login', [Authcontroller::class, 'login']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('classrooms', ClassroomController::class);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('pelajarans', PelajaranController::class);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('absensi', AbsensiSiswaController::class);
});


// Gunakan middleware auth:sanctum atau jwt jika perlu
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserProfileController::class, 'show']);
    Route::put('/user/{id}', [UserProfileController::class, 'update']);
});
