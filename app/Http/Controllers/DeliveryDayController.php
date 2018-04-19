<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\DeliveryDay;
use App\Http\Resources\DeliveryDay as DeliveryDayResource;

class DeliveryDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $deliveryDays = DeliveryDay::where('shop_id', $request->shop_id)
                                    ->where('market_id', $request->market_id)
                                    ->orderByRaw("FIELD(day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')")
                                    ->get();
        
        return DeliveryDayResource::collection($deliveryDays);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DeliveryDay  $deliveryDay
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryDay $deliveryDay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DeliveryDay  $deliveryDay
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryDay $deliveryDay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeliveryDay  $deliveryDay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryDay $deliveryDay)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeliveryDay  $deliveryDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryDay $deliveryDay)
    {
        //
    }
}
