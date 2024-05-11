<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::middleware('auth:sanctum')->group(static function () {
    Route::apiresource('tasks', TaskController::class);
    Route::put('tasks/{task}/status', [TaskController::class, 'changeStatus'])->name('tasks.status');
});

