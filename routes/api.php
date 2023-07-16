<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiCategoryController;
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

Route::middleware("Api_auth")->group(function () {
    //products store
    Route::post("products/store", [ApiCategoryController::class, "store"]);
    //products update
    Route::put("products/update/{id}", [ApiCategoryController::class, "update"]);
    //products delete
    Route::delete("products/delete/{id}", [ApiCategoryController::class, "delete"]);
    //Auth logout
    Route::post("logout", [ApiAuthController::class, "logout"]);
});
//all Products
Route::get("products", [ApiCategoryController::class, "all"]);
//show product
Route::get("products/show/{id}", [ApiCategoryController::class, "show"]);

//Auth Register
Route::post("register", [ApiAuthController::class, "register"]);
//Auth login
Route::post("login", [ApiAuthController::class, "login"]);
