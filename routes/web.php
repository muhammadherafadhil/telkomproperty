<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataPegawaiController;

Route::middleware('auth')->group(function () {
    Route::get('/data-pegawai', [DataPegawaiController::class, 'index'])->name('data-pegawai.index');
    Route::get('data-pegawai/{nik}/edit', [DataPegawaiController::class, 'edit'])->name('data-pegawai.edit');
    Route::patch('data-pegawai/{nik}', [DataPegawaiController::class, 'update'])->name('data-pegawai.update');
});


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form')->middleware(['auth', 'checkAdmin']);
Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware(['auth', 'checkAdmin']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', action: [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Route protected untuk dashboard
Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda')->middleware('auth');
