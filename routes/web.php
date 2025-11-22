<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChirpController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::resource('chirps', ChirpController::class)
        ->only(['store', 'edit', 'update', 'destroy']);
    Route::get('/profile', Profile::class);

    Route::post('/logout', Logout::class)
        ->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')
        ->name('register');
    Route::post('/register', Register::class);
    Route::view('/login', 'auth.login')
        ->name('login');
    Route::post('/login', Login::class);
});
