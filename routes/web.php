<?php

use App\Http\Livewire\Profile;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
// Route::get('/', 'auth.register');
// Route::get('/', App\Http\Livewire\Auth\Register::class);
// Route::get('/register', App\Http\Livewire\Auth\Register::class);


/**
 * App Routes
 */
Route::redirect('/', 'dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class);
    Route::get('/profile', Profile::class);
});

/**
 * Authentication
 */
Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class);
    Route::get('/login', Login::class)->name('login');
});
