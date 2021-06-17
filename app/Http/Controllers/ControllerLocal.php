<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerLocal extends Controller
{
    public function index(Request $req)
    {
        return view('local.test');
    }
}
