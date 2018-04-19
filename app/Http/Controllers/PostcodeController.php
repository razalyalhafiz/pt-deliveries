<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Postcode;
use App\Http\Resources\Postcode as PostcodeResource;

class PostcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $shop_id
     * @return \Illuminate\Http\Response
     */
    public function index($shop_id)
    {
        $postcodes = Postcode::join('markets', 'postcodes.market_id', '=', 'markets.id')
                                ->select('postcodes.id', 'markets.market_name', 'postcodes.postcode', 'postcodes.area', 'markets.id AS market_id')
                                ->where('postcodes.shop_id', $shop_id)
                                ->orderByRaw('markets.market_name, postcodes.postcode')
                                ->get();
       
        return PostcodeResource::collection($postcodes);
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
     * @param  int  $postcode
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $postcode)
    {
        $postcode = Postcode::join('markets', 'postcodes.market_id', '=', 'markets.id')
                                ->select('postcodes.id', 'markets.market_name', 'postcodes.postcode', 'postcodes.area', 'markets.id AS market_id')
                                ->where('postcodes.shop_id', $request->shop_id)
                                ->where('postcodes.postcode', $postcode)
                                ->first();
       
        return $postcode != null? new PostcodeResource($postcode) : array( 'data' => null );
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
