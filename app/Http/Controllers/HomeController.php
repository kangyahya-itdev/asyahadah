<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class HomeController extends Controller
{
    public function index(){
        $user = Auth::user();
        $amount = $user->commissions()->sum('amount');
        return view('user_area.home',[
            'title' => 'Home',
            'user' => $user,
            'amount' => $amount,
        ]);
    }
}
