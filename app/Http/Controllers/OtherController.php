<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OtherController extends Controller
{
    //View Analytics
    public function showAnalytics()
    {
        return view('dashboard.analytics');
    }
}
