<?php

use App\Exports\ProductExport;
use App\Exports\StockInExport;
use App\Exports\StockOutExport;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardMaterialController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardWorkorderController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\WorkorderController;
use App\Models\Form;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[AuthController::class,'index'])->name('login')->middleware('guest');


// Route::get('/login',[AuthController::class,'index'])->name('login')->middleware('guest');

Route::get('/login',[AuthController::class,'index'])->name('login')->middleware('guest');
Route::post('/login',[AuthController::class,'authenticate']);
Route::post('/logout',[AuthController::class,'logout']);

Route::get('/dashboard',[DashboardController::class,'index'])->middleware('auth');

Route::resource('/dashboard/product',InventoryItemController::class)->middleware('auth');

Route::resource('/dashboard/stockIn',StockInController::class)->middleware('auth');

Route::resource('/dashboard/stockOut',StockOutController::class)->middleware('auth');

Route::resource('/dashboard/user',DashboardUserController::class)->middleware('auth');

Route::get('/export-stock-in', function () {
    return Excel::download(new StockInExport, 'stock_in.xlsx');
});

// Route for Stock Out Export
Route::get('/export-stock-out', function () {
    return Excel::download(new StockOutExport, 'stock_out.xlsx');
});

Route::get('/export-products', function () {
    return Excel::download(new ProductExport, 'products.xlsx');
});
// // Route::get('/forms/{form}/export-pdf', [FormController::class, 'exportPdf'])->name('forms.export-pdf');
// Route::get('/dashboard/stockIn/{id}', [StockInController::class, 'showStockIn'])->name('dashboard.stock-in.show');

Route::get('/dashboard/product/create', [InventoryItemController::class, 'create']); // Show create form
Route::post('/dashboard/product', [InventoryItemController::class, 'store']); // Handle form submission