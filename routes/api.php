<?php

use Illuminate\Http\Request;
use App\Http\Middleware\OAuthLogin;

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
Route::put('login', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken')->middleware(OAuthLogin::class);
//前台路由
Route::post('items', 'Product\ProductController@items');
Route::post('product', 'Product\ProductController@product');
Route::post('product/index', 'Product\ProductController@productIndex');
Route::post('product/detail', 'Product\ProductController@productDetail');
Route::post('items/child','Product\ProductController@itemsChild');
Route::post('banner','Product\ProductController@bannerIndex');


