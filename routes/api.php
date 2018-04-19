<?php

// header('Access-Control-Allow-Origin:  *');
// header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

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

/*
|--------------------------------------------------------------------------
| Blackout Day Routes
|--------------------------------------------------------------------------
*/

// Display a listing of blackout days.
Route::get('blackouts', 'BlackoutDayController@index');

/*
|--------------------------------------------------------------------------
| Delivery Day Routes
|--------------------------------------------------------------------------
*/

// Display a listing of delivery days.
Route::get('days', 'DeliveryDayController@index');

/*
|--------------------------------------------------------------------------
| Delivery Hour Routes
|--------------------------------------------------------------------------
*/

// Display a listing of delivery hours.
Route::get('delivery-hours', 'DeliveryHourController@index');

// Display the delivery hours for a specific day.
Route::get('delivery-hours/{day}', 'DeliveryHourController@show');

/*
|--------------------------------------------------------------------------
| Timeslot Routes
|--------------------------------------------------------------------------
*/

// Display the available timeslots by day for a specific market.
Route::get('timeslots', 'TimeslotController@index');

// Display the next available timeslots for a specific market.
Route::get('timeslots/{day}', 'TimeslotController@show');

/*
|--------------------------------------------------------------------------
| Delivery Routes
|--------------------------------------------------------------------------
*/

// Display a listing of deliveries.
Route::get('deliveries', 'DeliveryController@index');

/*
|--------------------------------------------------------------------------
| Market Routes
|--------------------------------------------------------------------------
*/

// Display a listing of markets.
Route::get('markets/{shop_id}', 'MarketController@index');

// Display the specified market.
Route::get('markets/{shop_id}/{market_id}', 'MarketController@show');

// Create a new market.
Route::post('market/{shop_id}', 'MarketController@store');

// Update the specified market.
Route::put('market/{shop_id}', 'MarketController@store');

// Delete the specified market.
Route::delete('markets/{shop_id}/{market}', 'MarketController@delete');

/*
|--------------------------------------------------------------------------
| Postcode Routes
|--------------------------------------------------------------------------
*/

// Display a listing of postcodes.
Route::get('postcodes/{shop_id}', 'PostcodeController@index');

// Get market based on postcode.
Route::get('postcode/{postcode}', 'PostcodeController@show');

/*
|--------------------------------------------------------------------------
| Products Routes
|--------------------------------------------------------------------------
*/

// Display the products of a specific collection.
Route::get('products', 'ProductController@getProductsOfCollection');
