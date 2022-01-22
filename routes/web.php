<?php
Route::get('/', function () {
    return route('auth.register');
});

Route::livewire('/register', 'auth.register')->layout('layouts.auth')->name('auth.register');