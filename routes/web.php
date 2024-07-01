<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardMaterialController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardWorkorderController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\WorkorderController;
use App\Models\Form;
use Illuminate\Support\Facades\Route;

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

Route::get('/about', function () {
    return view('about',[
        "title" => "About",
    ]);
});


// Route::get('/login',[AuthController::class,'index'])->name('login')->middleware('guest');

Route::get('/login',[AuthController::class,'index'])->name('login')->middleware('guest');
Route::post('/login',[AuthController::class,'authenticate']);
Route::post('/logout',[AuthController::class,'logout']);

Route::get('/dashboard',[DashboardController::class,'index'])->middleware('auth');

Route::resource('/dashboard/forms',FormController::class)->middleware('auth');
Route::get('/dashboard/forms/{form}/formchecks', [FormController::class, 'showFormChecks'])->name('forms.formchecks');

Route::post('/forms/{form}/approve', [FormController::class, 'approve'])->name('forms.approve');

// Route for rejecting the form
Route::post('/forms/{form}/reject', [FormController::class, 'reject'])->name('forms.reject');

Route::resource('/dashboard/material',DashboardMaterialController::class)->middleware('auth');
Route::resource('/dashboard/user',DashboardUserController::class)->middleware('auth');

Route::resource('/workorder',WorkorderController::class);
