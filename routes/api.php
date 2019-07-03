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
Route::post('getarea','MainController@getarea');
Route::post('restaurants','MainController@getrestaurants');
Route::get('restaurants/{id}','MainController@getrestaurantdata');
Route::get('restaurants/{id}/comments','MainController@getcomments');
Route::post('restaurants/{id}/comments','MainController@postcomment');
Route::post('restaurants/add','MainController@addrestaurants');
// Route::post('removeurl','MainController@removeurl');
// Route::post('activate','MainController@activate');
// Route::post('deactivate','MainController@deactivate');
// Route::get('getdata','MainController@getdata');
