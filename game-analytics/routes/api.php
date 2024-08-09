<?php

use App\Http\Controllers\Api\OnlineUsersController;

Route::get('online-users/live', [OnlineUsersController::class, 'liveCount']);
Route::get('online-users/chart', [OnlineUsersController::class, 'chartData']);
Route::get('online-users/table', [OnlineUsersController::class, 'tableData']);