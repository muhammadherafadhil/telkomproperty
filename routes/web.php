<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataPegawaiController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RencanaController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\EmployeeCountController;
use App\Http\Controllers\HistoryLogController;
use App\Http\Controllers\LogInteractionController;
use App\Http\Controllers\HobiController;
use App\Http\Controllers\KeterampilanController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PenghargaanController;
use App\Http\Controllers\RiwayatJabatanController;

// Route untuk lokasi (kabupaten, kecamatan, kelurahan)
Route::get('/location/kabupaten/{id_prov}', [DataPegawaiController::class, 'getKabupaten'])->name('location.kabupaten');
Route::get('/location/kecamatan/{id_kab}', [DataPegawaiController::class, 'getKecamatan'])->name('location.kecamatan');
Route::get('/location/kelurahan/{id_kec}', [DataPegawaiController::class, 'getKelurahan'])->name('location.kelurahan');

// Route untuk login dan logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Route untuk register, hanya bisa diakses oleh admin
Route::middleware(['auth', 'checkAdmin'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Route untuk data pegawai, hanya bisa diakses oleh user yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/data-pegawai', [DataPegawaiController::class, 'index'])->name('data-pegawai.index');
    Route::get('/data-pegawai/{nik}/edit', [DataPegawaiController::class, 'edit'])->name('data-pegawai.edit');
    Route::patch('/data-pegawai/{nik}', [DataPegawaiController::class, 'update'])->name('data-pegawai.update');
});

// Rute untuk mengelola rencana (plans)
Route::middleware('auth')->group(function () {
    Route::get('/plans', [RencanaController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [RencanaController::class, 'create'])->name('plans.create');
    Route::post('/plans', [RencanaController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}', [RencanaController::class, 'show'])->name('plans.show');
    Route::get('/plans/{plan}/edit', [RencanaController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}', [RencanaController::class, 'update'])->name('plans.update');
    Route::delete('/plans/{plan}', [RencanaController::class, 'destroy'])->name('plans.destroy');
});

// Rute untuk performance (admin dan user)
Route::middleware('auth')->group(function () {
    Route::get('/admin/performance', [PerformanceController::class, 'adminIndex'])->name('admin.performance.index');
    Route::get('/admin/performance/create', [PerformanceController::class, 'createForAdmin'])->name('admin.performance.create');
    Route::post('/admin/performance', [PerformanceController::class, 'store'])->name('admin.performance.store');
});

// Rute untuk pengguna biasa yang mengelola kinerja mereka sendiri
Route::prefix('performance')->middleware('auth')->group(function() {
    Route::get('/', [PerformanceController::class, 'index'])->name('performance.index');
    Route::get('create', [PerformanceController::class, 'createForUser '])->name('performance.create');
    Route::post('/', [PerformanceController::class, 'store'])->name('performance.store');
    Route::get('edit/{performance}', [PerformanceController::class, 'edit'])->name('performance.edit');
    Route::put('update/{performance}', [PerformanceController::class, 'update'])->name('performance.update');
    Route::delete('destroy/{performance}', [PerformanceController::class, 'destroy'])->name('performance.destroy');
});

// Rute untuk Property (Properti)
Route::middleware('auth')->group(function () {
    Route::get('/properties', [PropertyController::class, 'index'])->name('property.index');
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('property.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('property.store');
    Route::get('/properties/{id}', [PropertyController::class, 'show'])->name('property.show');
    Route::get('/properties/{id}/edit', [PropertyController::class, 'edit'])->name('property.edit');
    Route::put('/properties/{id}', [PropertyController::class, 'update'])->name('property.update');
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy'])->name('property.destroy');
});

// Rute untuk menghitung jumlah pegawai
Route::get('/api/employee-count', [EmployeeCountController::class, 'getEmployeeCount']);
Route::post('/employee-count', [EmployeeCountController::class, 'updateEmployeeCount']);

// Rute untuk halaman beranda dan history logs
Route::get('/beranda', [HistoryLogController::class, 'index'])->name('beranda');

// Rute untuk history logs, hanya bisa diakses oleh pengguna yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/history-logs', [HistoryLogController::class, 'showHistoryLogs'])->name('history-logs.index');
    Route::post('/comment', [HistoryLogController::class, 'storeComment'])->name('comment.store');
    Route::post('/like', [HistoryLogController::class, 'likeHistoryLog'])->name('history-log.like');
});

// Menambahkan komentar dan like pada log activity
Route::post('/logs/{log}/like', [LogInteractionController::class, 'like'])->name('logs.like');
Route::post('/logs/{log}/comment', [LogInteractionController::class, 'comment'])->name('logs.comment');
Route::middleware(['auth', 'admin'])->post('/logs/{id}/validate', [HistoryLogController::class, 'validateLog']);

// ====================== ROUTE HOBI ======================
Route::middleware('auth')->group(function () {
    Route::resource('hobi', HobiController::class);
});

// ====================== ROUTE KETERAMPILAN ======================
Route::middleware('auth')->group(function () {
    Route::resource('keterampilan', KeterampilanController::class);
});

// ====================== ROUTE PELATIHAN ======================
Route::middleware('auth')->group(function () {
    Route::resource('pelatihan', PelatihanController::class);
});

// ====================== ROUTE PENDIDIKAN ======================
Route::middleware('auth')->group(function () {
    Route::resource('pendidikan', PendidikanController::class);
});

// ====================== ROUTE PENGHARGAAN ======================
Route::middleware('auth')->group(function () {
    Route::resource('penghargaan', PenghargaanController::class);
});

// ====================== ROUTE RIWAYAT JABATAN ======================
Route::middleware('auth')->group(function () {
    Route::resource('riwayatjabatan', RiwayatJabatanController::class);
});
