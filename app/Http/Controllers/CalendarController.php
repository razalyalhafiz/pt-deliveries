<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
  /**
   * Index route which displays the calendar page of the app.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      return view('calendar.index');
  }
}
