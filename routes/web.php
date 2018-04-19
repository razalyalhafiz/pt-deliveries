<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return('welcome');
// });

Route::get(
     '/',
     'HomeController@index'
 )
 ->middleware('auth.shop')
 ->name('home');

// Define a catch-all route to the HomeController which means
// that any web route will map to our SPA
Route::get('/{any}', 'HomeController@index')->where('any', '.*');