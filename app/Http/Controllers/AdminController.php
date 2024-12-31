<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request){

        return view('admin_area.dashboard', [
            'title'=>'Dashboard',
            'user'=> Auth::user()
        ]);
    }
}
