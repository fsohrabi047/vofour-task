<?php

use App\Http\Controllers\Admin\TaskController as AdminTaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');

Route::post('register', RegisterController::class)->name('register');

Route::prefix('admin')
    ->middleware(['role:admin', 'auth:sanctum'])
    ->name('admin.')
    ->group(
        function () {
            Route::resource('tasks', AdminTaskController::class)
                ->except(['create', 'edit']);
            Route::resource('users', UserController::class)
                ->except(['create', 'edit']);
        }
    );

Route::middleware('auth:sanctum', 'role:subscriber')
    ->name('tasks.')
    ->group(
        function () {
            Route::resource('tasks', TaskController::class)
                ->except(['create', 'edit']);
        }
    );