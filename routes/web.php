<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\PasswordResetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute untuk menampilkan halaman reset password
Route::get('/reset-password/{token}', function (Request $request, $token) {
    return view('auth.riset-password', [
        'token' => $token,
        'email' => $request->query('email'),
    ]);
})->name('password.reset');

Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');


// Rute untuk halaman utama (jika diperlukan)
// Route::get('/', function () {
//     return view('welcome');
// });