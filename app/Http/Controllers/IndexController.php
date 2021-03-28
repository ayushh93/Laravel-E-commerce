<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    //index page
    public function index()
    {
        return view('front.index');
    }
}
