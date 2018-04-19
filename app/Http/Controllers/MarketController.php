<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Market;
use App\Http\Resources\Market as MarketResource;

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($shop_id)
    {
        // $markets = Market::orderBy('market_name', 'asc')->paginate(10);
        $markets = Market::where('shop_id', $shop_id)
                            ->where('status', 1)
                            ->orderBy('market_name', 'asc')
                            ->get();
        
        return MarketResource::collection($markets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $market = $request->isMethod('put') ? Market::findOrFail($request->id) : new Market;

        $market->id = $request->input('id');
        $market->shop_id = $request->input('shop_id');
        $market->market_name = $request->input('market_name');
        $market->status = $request->input('status');

        if($market->save()) {
            return new MarketResource($market);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($shop_id, $market_id)
    {
      $market = Market::findOrFail($market_id);

      return new MarketResource($market);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get article
        $market = Market::findOrFail($id);
        if($market->delete()) {
            return new ArticleResource($article);
        }
    }
}
