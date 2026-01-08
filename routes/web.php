<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('expenses', 'expenses')
    ->middleware(['auth', 'verified'])
    ->name('expenses');

Route::view('expense-list', 'expense-list')
    ->middleware(['auth', 'verified'])
    ->name('expense-list');

Route::view('settings', 'settings')
    ->middleware(['auth'])
    ->name('settings');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
