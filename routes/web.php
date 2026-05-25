<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\InternshipApplicationController;
use App\Http\Controllers\InternshipOfferController;
use App\Http\Controllers\LogbookEntryController;
use App\Http\Controllers\PartnerDirectoryController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupervisorUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/masuk', [LoginController::class, 'create'])->name('login');
    Route::post('/masuk', [LoginController::class, 'store'])->name('login.store');
    Route::get('/daftar', [RegisterController::class, 'create'])->name('register');
    Route::post('/daftar', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/keluar', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/pembimbing', [SupervisorUserController::class, 'index'])->name('supervisors.index');
    Route::post('/pembimbing', [SupervisorUserController::class, 'store'])->name('supervisors.store');

    Route::get('/jelajah-perusahaan', [PartnerDirectoryController::class, 'companies'])->name('directories.companies');
    Route::get('/jelajah-universitas', [PartnerDirectoryController::class, 'universities'])->name('directories.universities');

    Route::get('/kemitraan', [PartnershipController::class, 'index'])->name('partnerships.index');
    Route::post('/kemitraan', [PartnershipController::class, 'store'])->name('partnerships.store');
    Route::patch('/kemitraan/{partnership}', [PartnershipController::class, 'update'])->name('partnerships.update');

    Route::resource('lowongan', InternshipOfferController::class)
        ->parameters(['lowongan' => 'offer'])
        ->names('offers');
    Route::patch('/review-lowongan/{offerRequest}', [InternshipOfferController::class, 'reviewUniversityRequest'])->name('offers.review');

    Route::get('/lamaran', [InternshipApplicationController::class, 'index'])->name('applications.index');
    Route::post('/lowongan/{offer}/lamar', [InternshipApplicationController::class, 'store'])->name('applications.store');
    Route::patch('/lamaran/{application}', [InternshipApplicationController::class, 'update'])->name('applications.update');

    Route::get('/tugas', [LogbookEntryController::class, 'index'])->name('logbooks.index');
    Route::post('/tugas', [LogbookEntryController::class, 'store'])->name('logbooks.store');
    Route::patch('/tugas/{logbook}', [LogbookEntryController::class, 'update'])->name('logbooks.update');

    Route::get('/evaluasi', [EvaluationController::class, 'index'])->name('evaluations.index');
    Route::post('/lamaran/{application}/evaluasi', [EvaluationController::class, 'store'])->name('evaluations.store');
});
