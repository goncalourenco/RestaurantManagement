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

//US9
Route::middleware(['auth:api', 'isCook'])->get('orders/cook/{id}', "OrderControllerAPI@getOrdersCook");
Route::middleware(['auth:api', 'isCook'])->get('orders/unassigned', "OrderControllerAPI@getUnassignedOrders");

//US11
Route::middleware(['auth:api', 'isCook'])->patch('order/{id}/assign', "OrderControllerAPI@assignOrder");
                                
//US 12
Route::middleware(['auth:api', 'isWaiter'])->post('meals/create', "MealControllerAPI@store");
Route::middleware(['auth:api', 'isWaiter'])->get('meals/availableTables', "MealControllerAPI@availableTables");

//US13
Route::middleware(['auth:api', 'isWaiter'])->get('waiter/meals', "MealControllerAPI@getMealsWaiter");
Route::middleware(['auth:api', 'isWaiter'])->post('orders/create', "OrderControllerAPI@store");

//US14
Route::middleware(['auth:api', 'isWaiter'])->get('waiter/orders', "OrderControllerAPI@getOrdersWaiter");

//US15
Route::middleware(['auth:api', 'isWaiter'])->delete('orders/{id}', "OrderControllerAPI@destroy");

//US17
Route::middleware(['auth:api', 'isWaiterOrCook'])->patch('order/{id}/state/', "OrderControllerAPI@changeState");

//US19
Route::middleware(['auth:api', 'isWaiter'])->get('meals/{id}/orders', "MealControllerAPI@getAllOrdersForMeal");

//US20
Route::middleware(['auth:api', 'isWaiter'])->patch('meals/{id}/terminate', "MealControllerAPI@terminateOrder");

//US22
Route::middleware(['auth:api', 'isCashier'])->post('cashier/invoices', "InvoiceControllerAPI@listInvoices");


Route::middleware(['auth:api', 'isWaiter'])->patch('meals/{id}/terminate', "MealControllerAPI@terminateMeal");

//US28
Route::middleware(['auth:api', 'isManager'])->get('tables', "TableControllerAPI@index");
Route::middleware(['auth:api', 'isManager'])->post('tables', "TableControllerAPI@store");
Route::middleware(['auth:api', 'isManager'])->delete('table/{id}', "TableControllerAPI@destroy");