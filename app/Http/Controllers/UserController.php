<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        if($user->isAdmin()){
            return view('admin_area.user.index', [
                'title' => 'Data Users',
                'users' => User::all()
            ]);
        }else{
            return view('user_area.profile.index',[
                'title' => 'Profile',
                'user' => $user,
            ]);
        }
    }
    public function checkReferralCode(Request $request){
        $request->validate([
            'referral_code' => 'required|string|regex:/^[A-Z0-9]{10}$/'
        ]);
        $referralExists = User::where('referral_code', $request->referral_code)->exists();
        return response()->json([
            'exists' => $referralExists,
        ]);

    }
    public function getUplineIdByReferral($referral){
        $user = User::where('referral_code', $referral)->first();
        return $user ? $user->id : null;

    }
    public function generateReferralCode()
    {
        do {
            // Generate 3 random letters
            $letters = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));
            
            // Generate 7 random digits
            $digits = substr(str_shuffle('0123456789'), 0, 7);
            
            // Combine letters and digits to form the referral code
            $referralCode = $letters . $digits;

            // Check for uniqueness in the users table
        } while (User::where('referral_code', $referralCode)->exists());

        return $referralCode;
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text_telephone' => 'required|string|max:15',
            'text_name' => 'required|string|max:255',
            'text_mail' => 'required|email|max:255',
            'text_password' => 'required|string|min:8|confirmed',
            'kode_referral' => 'nullable|string|exists:users,referral_code',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'handphone' => $request->text_telephone,
            'name' => $request->text_name,
            'email' => $request->text_mail,
            'password' => bcrypt($request->text_password),
            'referral_code' => $this->generateReferralCode(),
            'referred_by' => $request->kode_referral,
            'upline_id' => $this->getUplineIdByReferral($request->kode_referral),
        ]);
        if($user){
            Auth::login($user);
            return redirect()->route('login')->with('success', 'User created successfully');
        }
        return redirect()->route('register')->with('error', 'User created failed');
    }
    public function setLogin(Request $request)
    {
        $request->validate([
            'handphone' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt(['handphone' => $request->handphone, 'password' => $request->password])) {
            return back()->with('error', 'Login failed. Invalid credentials.');
        }

        $user = Auth::user();

        // cek peran user
        if ($user->isAdmin()) {
            $redirectRoute = 'admin.dashboard'; // Rute untuk admin
            $message = 'Login successful as Admin.';
        } else {
            $redirectRoute = 'user_area'; // Rute untuk user biasa
            $message = 'Login successful.';
        }

        $token = $user->createToken(env('TOKEN_NAME', 'DefaultTokenName'))->plainTextToken;

        // Simpan token ke session
        session(['token' => $token]);
         return redirect()->route($redirectRoute)->with('success', $message);
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully');
    }

}
