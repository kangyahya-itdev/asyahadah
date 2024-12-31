<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function index(Request $request){
        return view('welcome');
    }
    public function login(Request $request){

        if (Auth::check()) {
            // Redirect ke user_area jika sudah login
            $user = Auth::user();
            if($user->isAdmin()){
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('user_area');
            }
        }
        return view('login');
    }
    public function register(Request $request){

        return view('register',[
            'kode_referral' => $request->query('kode_referral')
        ]);
    }
}
