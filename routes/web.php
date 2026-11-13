<?php

use App\Http\Controllers\AcademicController;
use App\Http\Controllers\KrskhsController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrasiController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Halaman praktikum sebelumnya.
    Route::get('/home', [PageController::class, 'home']);
    Route::get('/biodata', [PageController::class, 'profile']);
    Route::get('/media', [PageController::class, 'media']);
    Route::get('/services', [PageController::class, 'services']);
    Route::get('/transaction', [PageController::class, 'transaction']);
    Route::get('/report', [PageController::class, 'report']);
    Route::get('/movie', [MovieController::class, 'index']);
    Route::get('/credit', [PageController::class, 'credit']);
    Route::get('/reward', [PageController::class, 'reward']);
    Route::match(['get', 'post'], '/proses', [PageController::class, 'proses']);
});

Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::redirect('/dashboard-dosen', '/dashboard')->name('dashboard.dosen');
    Route::get('/mahasiswa', [AcademicController::class, 'mahasiswa'])->name('mahasiswa.index');
    Route::get('/dosen', [AcademicController::class, 'dosen'])->name('dosen.index');
    Route::get('/matakuliah', [AcademicController::class, 'matakuliah'])->name('matakuliah.index');
    Route::get('/jadwal', [AcademicController::class, 'jadwal'])->name('jadwal.index');
});

Route::middleware(['auth', 'role:dosen,mahasiswa'])->group(function () {
    Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi.index');
    Route::get('/registrasi/{registrasi}', [RegistrasiController::class, 'show'])->name('registrasi.show');
    Route::get('/krskhs/pdf', [KrskhsController::class, 'pdf'])->name('krskhs.pdf');
    Route::redirect('/krskhs', '/registrasi')->name('krskhs.index');
});

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/krskhs/create', [KrskhsController::class, 'create'])->name('krskhs.create');
    Route::post('/krskhs', [KrskhsController::class, 'store'])->name('krskhs.store');
    Route::delete('/krskhs/{krskhs}', [KrskhsController::class, 'destroy'])->name('krskhs.destroy');
});

Route::view('/welcome', 'welcome');

require __DIR__.'/auth.php';
