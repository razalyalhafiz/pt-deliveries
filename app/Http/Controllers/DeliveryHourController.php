<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\DeliveryDay;
use App\Models\DeliveryHour;
use App\Http\Resources\DeliveryHour as DeliveryHourResource;

class DeliveryHourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $timeslots = DeliveryHour::where('shop_id', $request->shop_id)
                                    ->where('market_id', $request->market_id)
                                    ->orderByRaw("FIELD(day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'), time_from")
                                    ->get();
        
        return DeliveryHourResource::collection($timeslots);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  string $day
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $day)
    {
        $timeslots = DeliveryHour::where('shop_id', $request->shop_id)
                                    ->where('market_id', $request->market_id)
                                    ->where('day', $day)
                                    ->orderBy('time_from', 'asc')
                                    ->get();
        
        return DeliveryHourResource::collection($timeslots);
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
        //
    }
}
