<?php
// Route::get('/', 'auth.register');
Route::get('/', App\Http\Livewire\Auth\Register::class);
Route::get('/register', App\Http\Livewire\Auth\Register::class);