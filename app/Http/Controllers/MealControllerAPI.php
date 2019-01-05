<?php

namespace App\Http\Controllers;

use App\Meal;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Resources\Meal as MealResource;
use App\Rules\TableWithoutMealRule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RestaurantTable as RestaurantTableResource;
use App\RestaurantTable;
use App\Http\Resources\Order as OrderResource;
use App\Invoice;
use App\InvoiceItem;

class MealControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MealResource::collection(Meal::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =$request->validate([
            'table_number' => ['required', 'numeric', new TableWithoutMealRule],
        ]);
        $user = auth()->user();

        $meal = new Meal();
        $meal->table_number = $data['table_number'];
        $meal->start = date('Y-m-d H:m:s');
        $meal->responsible_waiter_id = $user->id;
        $meal->total_price_preview = 0;
        $meal->state = 'active';
        $meal->save(); 
        
        return new MealResource($meal);
        //return
        //$meals =  Meal::where('responsible_waiter_id', auth()->user()->id)->where('state', 'active')->get();
        //return MealResource::collection($meals);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meal $meal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        //
    }

    public function availableTables(Request $request){
        $tablesWithActiveMeals = Meal::where('state', 'active')->get()->pluck('table_number');

        $tablesWithoutActiveMeals = RestaurantTable::whereNotIn('table_number',$tablesWithActiveMeals)->get();

        return RestaurantTableResource::collection($tablesWithoutActiveMeals);
    }

    public function getMealsWaiter(Request $request){
        $meals =  Meal::where('responsible_waiter_id', auth()->user()->id)->where('state', 'active')->get();
        return MealResource::collection($meals);
    }

    public function getAllOrdersForMeal(Request $request, $id){
        $meal = Meal::findOrFail($id);
        return OrderResource::collection($meal->orders);   
    }

    public function terminateMeal(Request $request , $id){
        $meal = Meal::findOrFail($id);
        foreach($meal->orders as $order){
            if ($order->state != "delivered"){
                $meal->decrement('total_price_preview', (float)$order->item->price);
                $order->state = "not delivered";
                $order->save();
            }
        }
        $meal->state = "terminated";
        $meal->save();
        if($meal->total_price_preview <= 0){
            return new MealResource($meal);
        }

        $invoice = new Invoice();
        $invoice->state = "pending";
        $invoice->meal_id = $meal->id;
        $invoice->date = date('Y-m-d');
        $invoice->total_price = $meal->total_price_preview;
        $invoice->save();

        $orders = $meal->orders;
        $orders = $orders->filter(function ($order) {
            return $order->state == 'delivered';
        });
        foreach($orders as $order){
            $invoiceItem = InvoiceItem::where('invoice_id', $invoice->id)->where('item_id', $order->item_id)->first();
            if (isset($invoiceItem->invoice_id)){     
                DB::update('UPDATE invoice_items SET quantity = ?, sub_total_price = ? WHERE invoice_id = ? AND item_id = ?',
                [
                    $invoiceItem->quantity+ 1,
                    $invoiceItem->sub_total_price + $order->item->price,
                    $invoiceItem->invoice_id,
                    $invoiceItem->item_id
                ]);
            }else{
                DB::table('invoice_items')->insert([
                    'invoice_id' => $invoice->id, 
                    'item_id' => $order->item->id,
                    'quantity' => 1,
                    'unit_price' => $order->item->price,
                    'sub_total_price' => $order->item->price
                ]);               
            }    

        }

        return new MealResource($meal);
    }
}
