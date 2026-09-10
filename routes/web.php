<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', [EventController::class, 'index'])->name('home');
Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');
Route::post('/event/{id}/register', [EventController::class, 'register'])->name('event.register');

Route::middleware('auth')->group(function () {
    Route::get('/my-tickets', [UserDashboardController::class, 'myTickets'])->name('user.tickets');
});

Route::get('/ticket/{id}/download', [EventController::class, 'downloadTicket'])->name('ticket.download');

// Midtrans
Route::post('/api/midtrans-callback', [EventController::class, 'midtransCallback']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendOtp']);
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('verify-otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::get('/scanner', [\App\Http\Controllers\ScannerController::class, 'index'])->name('scanner');
Route::post('/scanner/process', [\App\Http\Controllers\ScannerController::class, 'process'])->name('scanner.process');
