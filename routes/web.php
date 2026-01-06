<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttractionController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth.custom')->group(function () {
    Route::get('/', [AttractionController::class, 'index'])->name('home');
    Route::post('/attractions', [AttractionController::class, 'store']);
    Route::put('/attractions/{id}', [AttractionController::class, 'update']);
    Route::delete('/attractions/{id}', [AttractionController::class, 'destroy']);
});
