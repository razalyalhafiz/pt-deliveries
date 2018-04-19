<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\BlackoutDay;
use App\Models\Delivery;
use App\Models\DeliveryDay;
use App\Models\DeliveryHour;
use App\Models\Market;
use App\Http\Resources\DeliveryHour as DeliveryHourResource;
use Carbon\Carbon;

class TimeslotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request_time_str = substr_replace($request->time, ":", 2, 0);
        $request_time = Carbon::createFromFormat('H:i', $request_time_str);

        $date = Carbon::now();
        $day = $date->format("l");
        $slot_found = false;
        $min_date = 0;   
        
        // Get market_id
        $market_id = Market::where('shop_id', $request->shop_id)
                            ->where('market_name', $request->market_name)
                            ->value('id');

        // Get lead offset
        $lead_offset = Market::where('id', $market_id)
                                ->where('shop_id', $request->shop_id)
                                ->value('lead_offset');

        if ($lead_offset) {
            // Add lead offset to the request time
            $delivery_time =  $request_time->addMinutes($lead_offset);
            $delivery_time_str = $delivery_time->format('H:i');
        } else {
            $delivery_time_str = $request_time_str;
        }     
        //
        // Get blackout days
        $blackout_days = TimeslotController::getBlackoutDays($request->shop_id, $market_id);

        // Get inactive days
        $inactive_days = TimeslotController::getInactiveDays($request->shop_id, $market_id);

        // Do until an available slot is found
        while (!$slot_found) {  

            // Check if $date is a blackout day
            if (in_array($date->toDateString(), $blackout_days)) {
                TimeslotController::incrementDay($date, $day, $min_date);
                continue; 
            }

            // Check if $day is an inactive day
            $is_active = DeliveryDay::where('shop_id', $request->shop_id)
                                        ->where('market_id', $market_id)
                                        ->where('day', $day)
                                        ->value('active');
            if (!$is_active) {
                TimeslotController::incrementDay($date, $day, $min_date);
                continue;
            }

            // Get the timeslots   
            if ($date->isToday()) {
                $timeslots = DeliveryHour::where('shop_id', $request->shop_id)
                                            ->where('market_id', $market_id)
                                            ->where('day', $day)
                                            ->where('time_from', '>', $delivery_time_str)
                                            ->orderBy('time_from', 'asc')
                                            ->get();
            } else {
                $timeslots = DeliveryHour::where('shop_id', $request->shop_id)
                                            ->where('market_id', $market_id)
                                            ->where('day', $day)                             
                                            ->orderBy('time_from', 'asc')
                                            ->get();
            }
            
            $available_timeslots = array();
        
            // Loop through each timeslot until an available slot is found
            foreach ($timeslots as $timeslot) {

                // Get # of deliveries for that slot
                $deliveries_count = Delivery::where('timeslot_id', $timeslot->id)->count();

                // Add to $result if slot limit has not been reached yet
                if ($deliveries_count < $timeslot->slot_limit) {
                    
                    // Set slot text
                    $t_from = Carbon::createFromFormat('H:i', $timeslot->time_from);
                    $t_from_str = $t_from->format('g:ia');
                    $t_to = Carbon::createFromFormat('H:i', $timeslot->time_to);
                    $t_to_str = $t_to->format('g:ia');

                    $available_timeslots[] = $t_from_str . ' - ' . $t_to_str;                   
                }
            }

            if (count($available_timeslots) == 0) {
                TimeslotController::incrementDay($date, $day, $min_date);
                continue;
            }

            $slot_found = true;
        }
        
        $result = array(
            'min_date' => $min_date,
            'date_time' => $date->toDayDateTimeString(),
            'request_time' => $delivery_time_str,
            'timeslots' => $available_timeslots,
            'blackout_days' => $blackout_days,
            'inactive_days' => $inactive_days
        );

        return json_encode($result);
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
     * @param  string  $day
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $day)
    {
        // Change delivery_date format
        $date = Carbon::createFromFormat('y-m-d', $request->date);
        $delivery_date = $date->format('D, d/m/Y');    

        // Get market_id
        $market_id = Market::where('shop_id', $request->shop_id)
                            ->where('market_name', $request->market_name)
                            ->value('id');

        return TimeslotController::getTimeslotsByDay($request->shop_id, $market_id, $day, $delivery_date);
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

    private static function incrementDay(&$date, &$day, &$min_date) {
        $date = $date->addDay();
        $day = $date->format('l');
        $min_date++;
    }

    private static function getTimeslotsByDay($shop_id, $market_id, $day, $delivery_date) {
        $result = array();
        
       $timeslots = DeliveryHour::where('shop_id', $shop_id)
                                    ->where('market_id', $market_id)
                                    ->where('day', $day)                             
                                    ->orderBy('time_from', 'asc')
                                    ->get();

        // Loop through each timeslot until an available slot is found
        foreach ($timeslots as $timeslot) {

            // Get # of deliveries for that slot
            $deliveries_count = Delivery::where('timeslot_id', $timeslot->id)
                                        ->where('delivery_date', $delivery_date)       
                                        ->count();

            // Add to $result if slot limit has not been reached yet
            if ($deliveries_count < $timeslot->slot_limit) {
                
                // Set slot text
                $t_from = Carbon::createFromFormat('H:i', $timeslot->time_from);
                $t_from_str = $t_from->format('g:ia');
                $t_to = Carbon::createFromFormat('H:i', $timeslot->time_to);
                $t_to_str = $t_to->format('g:ia');

                $result[] = $t_from_str . ' - ' . $t_to_str;                   
            }
        }

        return $result;
    }

    private static function getBlackoutDays($shop_id, $market_id) {
        $result = array();
        
        $blackout_days = BlackoutDay::where('shop_id', $shop_id)
                                        ->where('market_id', $market_id)
                                        ->get();
        
        foreach ($blackout_days as $blackout_day) {
           $result[] = $blackout_day->date;
        }

        return $result;
    }

    private static function getInactiveDays($shop_id, $market_id) {
        $result = array();

        $inactive_days = DeliveryDay::where('shop_id', $shop_id)
                                        ->where('market_id', $market_id)
                                        ->where('active', 0)
                                        ->get();

        foreach ($inactive_days as $inactive_day) {
            $js_day_id = 0;

            switch ($inactive_day->day) {
                case 'monday':
                    $js_day_id = 1;
                    break;

                case 'tuesday':
                    $js_day_id = 2;
                    break;

                case 'wednesday':
                    $js_day_id = 3;
                    break;

                case 'thursday':
                    $js_day_id = 4;
                    break;

                case 'friday':
                    $js_day_id = 5;
                    break;

                case 'saturday':
                    $js_day_id = 6;
                    break;

                case 'sunday':
                    $js_day_id = 0;
                    break;
                
                default:
                    break;
            }

            $result[] = $js_day_id;
        }
        
        return $result;
    }
}
