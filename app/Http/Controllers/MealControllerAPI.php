<?php

namespace App\Http\Controllers;

use App\Meal;
use Illuminate\Http\Request;
use App\Http\Resources\Meal as MealResource;
use App\Rules\TableWithoutMealRule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RestaurantTable as RestaurantTableResource;
use App\RestaurantTable;

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
        $meal->start = Carbon::now();
        $meal->responsible_waiter_id = $user->id;
        $meal->total_price_preview = 0;
        $meal->state = 'active';
        $meal->save(); 
        
        return new MealResource($meal);
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
}