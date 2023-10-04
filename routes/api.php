<?php

use App\Http\Controllers\Api\BoardController;
use App\Http\Controllers\Api\TaskController;
use App\Utils\Response;
use Illuminate\Support\Facades\Route;

Route::get('healthy', function () {
    return Response::success('OK');
});

Route::prefix('board')->group(function() {
    Route::get('all', [BoardController::class, 'getBoards']);
    Route::get('{uuid}', [BoardController::class, 'getBoard']);

    Route::post('create', [BoardController::class, 'createBoard']);

    Route::put('{uuid}', [BoardController::class, 'updateBoard']);

    Route::delete('{uuid}', [BoardController::class, 'removeBoard']);
});

Route::prefix('task')->group(function() {
    Route::get('all', [TaskController::class, 'getTasks']);
    Route::get('{uuid}', [TaskController::class, 'getTask']);

    Route::post('create', [TaskController::class, 'addTask']);

    Route::put('{uuid}', [TaskController::class, 'updateTask']);
    Route::put('{uuid}/move-to/{board-uuid}', [TaskController::class, 'moveBoardOfTask']);

    Route::delete('{uuid}', [TaskController::class, 'removeTask']);
});
