<?php

use Illuminate\Http\Request;

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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::namespace('Api')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::middleware('auth:api')->group(function() {
            Route::get('products', 'ProductController@index');
            Route::post('products', 'ProductController@store');
            
            Route::post('customers', 'CustomerController@store');
            
            Route::post('orders', 'OrderController@store');
            Route::put('orders/{id}', 'OrderController@cancelStatus');
            Route::get('orders', 'OrderController@index');
        });
    });
});