<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// ── Auth ─────────────────────────────────────────────────────────────────────
Route::get('/login', [LoginController::class, 'index'])
    ->name('login')
    ->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// ── Protected Routes ─────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [TransactionController::class, 'index']);
    Route::post('/', [CustomerController::class, 'search']);

    // Customer
    Route::get('/customer', [CustomerController::class, 'index']);
    Route::post('/customer', [CustomerController::class, 'store']);

    // Transaction
    Route::get('/transaction', [TransactionController::class, 'create']);
    Route::post('/transaction', [TransactionController::class, 'store']);
    Route::get('/transaction/view', [TransactionController::class, 'index']);
    Route::get('/transaction/export', [TransactionController::class, 'export']);
    Route::get('/transaction/upload', [TransactionController::class, 'upload']);
    Route::post('/transaction/upload', [TransactionController::class, 'import']);
    Route::get('/transaction/edit/{id}', [TransactionController::class, 'edit']);
    Route::put('/transaction/{id}', [TransactionController::class, 'update']);
    Route::delete('/transaction/delete/{id}', [TransactionController::class, 'delete']);

    // Account Admin
    Route::get('/account/admin', [AkunController::class, 'index']);
    Route::get('/account/create', [AkunController::class, 'create']);
    Route::post('/account/create', [AkunController::class, 'store']);
    Route::get('/account/admin/{user}/edit', [AkunController::class, 'edit']);
    Route::put('/account/admin/{user}', [AkunController::class, 'update']);
    Route::delete('/account/admin/{user}', [AkunController::class, 'destroy']);
});
