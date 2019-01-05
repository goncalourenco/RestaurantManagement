<?php

namespace App\Http\Controllers;

use App\RestaurantTable as Table;
use Illuminate\Http\Request;
use App\Http\Resources\RestaurantTable as TableResource;

class TableControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TableResource::collection(Table::all());
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
            'table_number'=>'required|integer|min:1|unique:restaurant_tables',
        ]);
        $table = new Table();
        $table->table_number = $data['table_number'];
        $table->save();
        return new TableResource($table);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RestaurantTable  $restaurantTable
     * @return \Illuminate\Http\Response
     */
    public function show(RestaurantTable $restaurantTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RestaurantTable  $restaurantTable
     * @return \Illuminate\Http\Response
     */
    public function edit(RestaurantTable $restaurantTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RestaurantTable  $restaurantTable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RestaurantTable $restaurantTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RestaurantTable  $restaurantTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $table = Table::findOrFail($id);
        $meals = $table->meals;

        if($meals->isEmpty()){
            $table->forceDelete();
            return new TableResource($table);
        }
        
        $table->delete();
        return new TableResource($table);
    }
}
