<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get("redirect",[HomeController::class,"redirect"]);
//index
Route::get("/",[HomeController::class,"index"]);
//index
Route::get("search",[HomeController::class,"search"]);
//all
Route::get("products",[AdminController::class,"allproducts"]);
//craete
Route::get("create",[AdminController::class,"create"]);
Route::post("store",[AdminController::class,"store"]);
//edit
Route::get("editProduct/{id}",[AdminController::class,"edit"]);
Route::put("updateProduct/{id}",[AdminController::class,"update"]);
//delete
Route::delete("deleteProduct/{id}",[AdminController::class,"delete"]);