<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
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
    // Fungsi untuk registrasi pengguna baru
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'handphone' => 'required|string|unique:users,handphone',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'referral_code' => 'string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
				'success' => false,
				'errors' => $validator->errors()
			], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'handphone' => $request->handphone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'referral_code' => $this->generateReferralCode(),
            'referred_by' => $request->referral_code,
            'upline_id' => $this->getUplineIdByReferral($request->referral_code),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'user' => $user,
        ]);
    }

    // Fungsi untuk login pengguna dan mendapatkan token
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loginField = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email':'handphone';

        // Cek kredensial pengguna
        if (Auth::attempt([$loginField => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $tokenName = env('TOKEN_NAME', 'DefaultTokenName'); // Default value if .env is not set
            $token = $user->createToken($tokenName)->plainTextToken;
            //$token = $user->createToken('AsyahadahStoreToken')->plainTextToken; // Membuat token

            return response()->json([
                'message' => 'Login successful',
                'success' => true,
                'token' => $token,
                'user' => $user,
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Fungsi untuk logout dan menghapus token
   public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete(); // Revoke the current token
        return response()->json(['message' => 'Successfully logged out']);
    }
}
