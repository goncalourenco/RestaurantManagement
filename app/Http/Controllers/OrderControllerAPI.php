<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResource;
use App\Order;
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;
use App\Meal;
use App\Http\Resources\Meal as MealResource;

class OrderControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authedUser = Auth::guard('api')->user();
        return OrderResource::Collection(Order::where("responsible_cook_id", $authedUser->id)->whereIn('state', array('in preparation', 'confirmed'))->orderBy('start', 'desc')->orderBy('state', 'desc')->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'meal_id' => 'required|exists:meals,id',
            'item_id' => 'required|exists:items,id'
        ]);

        $order = new Order();
        $order->state = 'pending';
        $order->meal_id = $data["meal_id"];
        $order->item_id = $data["item_id"];
        $order->start = date('Y-m-d H:m:s');
        $order->save();

        $meal = Meal::findOrFail($order->meal->id);
        $meal->total_price_preview += $order->item->price;
        $meal->save();

        //returns the meal to update the orders tables
        //return new MealResource($meal);
        return new OrderResource($order);
    }

    public function getOrdersWaiter(){
        $user = auth()->user();
        $orders = Order::join('meals', 'orders.meal_id', '=', 'meals.id')
        ->where('meals.state','active')
        ->where('meals.responsible_waiter_id', $user->id)->select(
            'orders.id',
            'orders.state',
            'orders.item_id',
            'orders.meal_id',
            'orders.start'

        )->get();

        $orders = $orders->filter(function ($order) {
            return $order->state == 'confirmed' || $order->state == 'pending' || $order->state == 'prepared';
        });

        $orders = $orders->sortBy('state');

        return OrderResource::collection($orders);
    }

    public function getOrdersCook(){
        $user = auth()->user();
        $orders = Order::whereIn('responsible_cook_id', array($user->id, null))
                        ->whereIn("state", array('in preparation', 'confirmed'))
                        ->orderBy('start', 'desc')->orderBy('state', 'desc')->paginate(10);
        return OrderResource::collection($orders);
    }

    public function getPreparedOrdersWaiter(){
        $user = auth()->user();
        $orders = Order::join('meals', 'orders.meal_id', '=', 'meals.id')
        ->where('meals.state','active')
        ->where('meals.responsible_waiter_id', $user->id)->select(
            'orders.id',
            'orders.state',
            'orders.item_id',
            'orders.meal_id',
            'orders.start'

        )->get();

        $orders = $orders->filter(function ($order) {
            return $order->state == 'prepared';
        });

        return OrderResource::collection($orders);
    }

    public function changeStatus(Request $request, $id){
        $order = Order::findOrFail($id);
        $order->state = $request->state;
        $order->save();

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $meal = $order->meal;
        $meal->total_price_preview = $meal->total_price_preview - $order->item->price;
        $meal->save();
        if($order->state == "pending"){
            $order->delete();
        }
        return new OrderResource($order);
    }
}
