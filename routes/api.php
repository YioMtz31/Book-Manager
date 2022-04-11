<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('author',AuthorController::class);
Route::apiResource('category',CategoryController::class);

Route::get('/books',[BookController::class,'index']);
Route::post('/books',[BookController::class,'store']);
Route::post('/author',[AuthorController::class,'store']);
Route::post('/category',[CategoryController::class,'store']);
