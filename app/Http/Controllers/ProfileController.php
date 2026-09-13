<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        
        $registrations = \App\Models\Registration::where('user_id', $user->id)
            ->with(['event', 'ticketType'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.profile', compact('user', 'registrations'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'string'],
        ]);

        if ($user->name !== $request->name) {
            if ($user->name_updated_at && $user->name_updated_at->copy()->addDay() > now()) {
                return back()->with('error', 'Anda hanya dapat mengubah nama sekali dalam 24 jam. Silakan coba lagi besok.');
            }
            $user->name = $request->name;
            $user->name_updated_at = now();
        }

        if ($request->has('bio')) {
            $user->bio = strip_tags($request->bio);
        }

        if ($request->has('phone')) {
            $user->phone = strip_tags($request->phone);
        }
        
        if ($request->has('avatar')) {
            $user->avatar = $request->avatar;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
