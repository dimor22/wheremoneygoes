<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('expenses', 'expenses')
    ->middleware(['auth', 'verified'])
    ->name('expenses');

Route::view('refunds', 'refunds')
    ->middleware(['auth', 'verified'])
    ->name('refunds');

Route::view('expense-list', 'expense-list')
    ->middleware(['auth', 'verified'])
    ->name('expense-list');

Route::view('projection', 'projection')
    ->middleware(['auth', 'verified'])
    ->name('projection');

Route::view('settings', 'settings')
    ->middleware(['auth'])
    ->name('settings');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('client-errors/livewire', function (Request $request) {
    if (! app()->isProduction()) {
        return response()->noContent();
    }

    $payload = $request->validate([
        'type' => ['required', 'string', 'max:100'],
        'message' => ['required', 'string', 'max:2000'],
        'source' => ['nullable', 'string', 'max:2000'],
        'line' => ['nullable', 'integer', 'min:0'],
        'column' => ['nullable', 'integer', 'min:0'],
        'stack' => ['nullable', 'string', 'max:10000'],
        'url' => ['nullable', 'string', 'max:2000'],
        'user_agent' => ['nullable', 'string', 'max:2000'],
    ]);

    Log::warning('Client-side auth page error', [
        'type' => $payload['type'],
        'message' => $payload['message'],
        'source' => $payload['source'] ?? null,
        'line' => $payload['line'] ?? null,
        'column' => $payload['column'] ?? null,
        'stack' => $payload['stack'] ?? null,
        'url' => $payload['url'] ?? null,
        'user_agent' => $payload['user_agent'] ?? null,
        'ip' => $request->ip(),
    ]);

    return response()->noContent();
})->middleware('throttle:60,1')->name('client-errors.livewire');

require __DIR__.'/auth.php';
