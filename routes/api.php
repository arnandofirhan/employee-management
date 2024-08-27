<?php

use App\Http\Controllers\Api\EntityController;
use App\Http\Controllers\Api\TemporaryFileController;
use App\Http\Controllers\Api\DepartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'temporary-files', 'as' => 'temporary-files.'], function () {
    Route::post('', [TemporaryFileController::class, 'index'])->name('index');
});

Route::group(['prefix' => 'entities', 'as' => 'entities.'], function () {
    Route::get('', [EntityController::class, 'index'])->name('index');
});

Route::group(['prefix' => 'departments', 'as' => 'departments.'], function () {
    Route::get('', [DepartmentController::class, 'index'])->name('index');
});
