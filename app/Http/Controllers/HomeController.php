<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class HomeController extends Controller
{
  /**
   * Index route which displays the home page of the app.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      return view('spa');
  }
}
