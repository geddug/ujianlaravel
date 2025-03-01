<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\ForgotPassword;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\ResetPassword;
use App\Livewire\VerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');

    Route::get('/login', Login::class)->name('login');

    Route::get('forgot-password', ForgotPassword::class)
        ->name('password.request');

    Route::get('reset-password/{token}', ResetPassword::class)
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', function() {
        Auth::logout();
        return redirect('/login');
    })->name('logout');

    Route::get('verify-email', VerifyEmail::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});
