<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Arahkan admin langsung ke Dasbor Admin
            if (Auth::user()->hasRole(['super_admin', 'organizer', 'scanner'])) {
                return redirect()->intended('/admin');
            }
            
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Email atau sandi salah.']);
    }

    public function showRegister() { return view('auth.register'); }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // OTP LOGIC
    public function showForgotPassword() { return view('auth.forgot-password'); }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $otp = rand(100000, 999999);
            // Simpan OTP ke session untuk kemudahan (atau ke DB)
            session(['otp_code' => $otp, 'otp_email' => $user->email, 'otp_expires' => now()->addMinutes(5)]);
            
            // Simulasi pengiriman email
            // Mail::to($user->email)->send(new SendOtpMail($otp));
            
            return redirect()->route('verify-otp')->with('success', "Kode OTP Anda: $otp (Hanya simulasi, catat kode ini)");
        }

        return back()->withErrors(['email' => 'Email tidak terdaftar.']);
    }

    public function showVerifyOtp() { return view('auth.verify-otp'); }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
        
        if (session('otp_code') == $request->otp && now()->lessThan(session('otp_expires'))) {
            session(['otp_verified' => true]);
            return redirect()->route('reset-password');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa.']);
    }

    public function showResetPassword() 
    {
        if (!session('otp_verified')) return redirect()->route('forgot-password');
        return view('auth.reset-password'); 
    }

    public function resetPassword(Request $request)
    {
        $request->validate(['password' => 'required|min:6|confirmed']);
        
        $user = User::where('email', session('otp_email'))->first();
        if ($user) {
            $user->update(['password' => Hash::make($request->password)]);
            session()->forget(['otp_code', 'otp_email', 'otp_expires', 'otp_verified']);
            return redirect()->route('login')->with('success', 'Sandi berhasil direset. Silakan masuk.');
        }

        return redirect()->route('forgot-password');
    }
}
