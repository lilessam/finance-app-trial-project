<?php

use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/transactions', [TransactionsController::class, 'all']);
    Route::post('/transactions', [TransactionsController::class, 'store']);
    Route::delete('/transactions/{id}', [TransactionsController::class, 'destroy']);
    Route::put('/transactions/{id}', [TransactionsController::class, 'update']);
    Route::post('/transactions/import', [TransactionsController::class, 'import']);
});
