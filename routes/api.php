<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\BlockController;
use App\Http\Controllers\Api\V1\PieceController;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('blocks', BlockController::class);
    Route::apiResource('pieces', PieceController::class);
});