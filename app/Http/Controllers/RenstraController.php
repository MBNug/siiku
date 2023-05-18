<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Departemen;

class RenstraController extends Controller
{
    //
    public function index(){

        $departemens = Departemen::all();
        
        return view('renstra.dashboard', compact('departemens'))->with([
            'user'=> Auth::user()
        ]);
    }
}
