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

Route::middleware(['auth:api', 'isCook'])->get('cooks/orders', "OrderControllerAPI@getOrdersCook");


//US 12
Route::middleware(['auth:api', 'isWaiter'])->post('meals/create', "MealControllerAPI@store");
Route::middleware(['auth:api', 'isWaiter'])->get('meals/availableTables', "MealControllerAPI@availableTables");
Route::middleware('auth:api')->get('orders', 'OrderControllerAPI@index');

//US13
Route::middleware(['auth:api', 'isWaiter'])->get('waiter/meals', "MealControllerAPI@getMealsWaiter");
Route::middleware(['auth:api', 'isWaiter'])->post('orders/create', "OrderControllerAPI@store");

//US14
Route::middleware(['auth:api', 'isWaiter'])->get('waiter/orders', "OrderControllerAPI@getOrdersWaiter");

//US15
Route::middleware(['auth:api', 'isWaiter'])->delete('orders/{id}', "OrderControllerAPI@destroy");

//US17
Route::middleware(['auth:api', 'isWaiter'])->patch('order/{id}/status/', "OrderControllerAPI@changeStatus");

//US19
Route::middleware(['auth:api', 'isWaiter'])->get('meals/{id}/orders', "MealControllerAPI@getAllOrdersForMeal");

//US20
Route::middleware(['auth:api', 'isWaiter'])->patch('meals/{id}/terminate', "MealControllerAPI@terminateOrder");