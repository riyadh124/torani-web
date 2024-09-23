<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\StockOutController;
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
    Route::get('/products', [InventoryItemController::class, 'getListProducts']);
    Route::get('/products-stock', [InventoryItemController::class, 'getInventoryWithStock']);
    Route::get('/products-count', [InventoryItemController::class, 'countStock']);
    Route::get('/stocks', [InventoryItemController::class, 'getStockMovements']);
    Route::resource('/stock-out',StockOutController::class);
    Route::get('/total-stock', [InventoryItemController::class, 'getTotalProductStock']);
});

