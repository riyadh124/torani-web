<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\WorkorderController;
use App\Models\Material;

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

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/forms', [FormController::class, 'store']);
    Route::post('/photo', [FormController::class, 'uploadPhoto']);

    Route::get('/forms', [FormController::class, 'getForms']);
    Route::get('/forms/{id}', [FormController::class, 'getDetailForm']);

    Route::resource('/workorder',WorkorderController::class);
    Route::resource('/material',MaterialController::class);
    Route::put('/workorder/{id}/update-status', [WorkorderController::class, 'updateStatus']);
    Route::put('/workorder/{id}/input-data', [WorkorderController::class, 'inputData']);
    Route::post('/upload-image', [WorkorderController::class, 'uploadImage']);
});

