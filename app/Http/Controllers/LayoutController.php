<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;


class LayoutController extends Controller
{
    public function index(){
        return view('layouts.home')->with([
            'user'=> Auth::user()
        ]);
    }
}
