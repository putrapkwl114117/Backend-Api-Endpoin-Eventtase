<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FormFieldController;

// Rute untuk registrasi pengguna baru
Route::post('/register', [AuthController::class, 'register']);

// Rute untuk login pengguna
Route::post('/login', [AuthController::class, 'login']);

// Rute untuk mengirim link reset password
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

// Rute untuk mereset password
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');


Route::post('/events', [EventController::class, 'create']);
//events routs endpoind
Route::post('/events/{event}/fields', [FormFieldController::class, 'create']);
Route::get('/events/{event}/fields', [FormFieldController::class, 'show']);


// Rute yang dilindungi untuk pendaftaran organisasi
Route::middleware('auth:sanctum')->post('/register-organization', [OrganizationController::class, 'store']);

// Rute untuk logout pengguna
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Rute untuk mendapatkan informasi pengguna yang terautentikasi
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});