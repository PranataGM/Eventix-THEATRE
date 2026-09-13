<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                // Jika user sudah ada (daftar manual), update google_id nya
                $updates = [];
                if (!$user->google_id) {
                    $updates['google_id'] = $googleUser->id;
                    $updates['google_token'] = $googleUser->token;
                    $updates['google_refresh_token'] = $googleUser->refreshToken;
                }
                if (!$user->avatar && $googleUser->avatar) {
                    $updates['avatar'] = $googleUser->avatar;
                }
                if (!empty($updates)) {
                    $user->update($updates);
                }
            } else {
                // Jika user belum ada, buat user baru
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'avatar' => $googleUser->avatar,
                    // Tetapkan password acak agar tidak kosong jika nullable diubah
                    'password' => bcrypt(Str::random(16)), 
                ]);
            }

            Auth::login($user);

            // Arahkan ke halaman utama tanpa pesan notifikasi
            return redirect()->route('home');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk menggunakan Google: ' . $e->getMessage());
        }
    }
}
