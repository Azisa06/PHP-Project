<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeAtdController extends Controller
{
    public function index(){
        return view('home-atd');
    }
}
