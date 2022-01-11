<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CatagoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/token', function () {
    return csrf_token();
});
// Route::resource('product', 'App\Http\Controller\ProductController');
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/search/{name}', [ProductController::class, 'search']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::post('/product/add', [ProductController::class, 'add']);
Route::put('/product/{id}/update', [ProductController::class, 'update']);
Route::put('/product/{id}/delete', [ProductController::class, 'del']);
// Route::post('/product/upload-file', [ProductController::class, 'store']);
// Route::post('/product/upload-file', 'App\Http\Controllers\ProductController@fileUpload');



Route::get('/catagory', [CatagoryController::class, 'index']);
Route::get('/catagory/{id}', [CatagoryController::class, 'show']);
Route::post('/catagory/add', [CatagoryController::class, 'add']);
Route::put('/catagory/{id}/update', [CatagoryController::class, 'update']);
Route::put('/catagory/{id}/delete', [CatagoryController::class, 'del']);
