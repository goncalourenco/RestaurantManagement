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
Route::get('users', 'UserControllerAPI@index');
Route::get('items', 'ItemControllerAPI@index');
Route::post('login', 'LoginControllerAPI@login');
Route::middleware('auth:api')->get('users/me', 'UserControllerAPI@myUserDetails');
Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');

Route::middleware('auth:api')->patch('users/password/{id}', 'UserControllerAPI@changePassword');
Route::middleware('auth:api')->put('users/{id}', 'UserControllerAPI@update');


//US 6
Route::middleware('auth:api')->patch('users/{id}/endshift', 'UserControllerAPI@endShift');
Route::middleware('auth:api')->patch('users/{id}/startshift', 'UserControllerAPI@startShift');


//US 12
Route::middleware(['auth:api', 'isWaiter'])->post('meals/create', "MealControllerAPI@store");
Route::middleware(['auth:api', 'isWaiter'])->get('meals/availableTables', "MealControllerAPI@availableTables");
Route::middleware('auth:api')->get('orders', 'OrderControllerAPI@index');