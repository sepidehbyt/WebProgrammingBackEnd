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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('getarea','MainController@getarea');
// Route::post('checkurl','MainController@checkurl');
// Route::post('addGroup','MainController@addGroup');
// Route::post('addurl','MainController@addurl');
// Route::post('removeurl','MainController@removeurl');
// Route::post('activate','MainController@activate');
// Route::post('deactivate','MainController@deactivate');
// Route::get('getdata','MainController@getdata');