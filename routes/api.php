<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::middleware('auth:sanctum')->prefix('tasks')->as('tasks.')->group(static function () {
    Route::resource('tasks', TaskController::class);
    Route::put('/{task}/status', [TaskController::class, 'changeStatus'])->name('status');
});

