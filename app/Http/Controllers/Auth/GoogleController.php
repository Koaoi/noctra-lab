<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleController extends Controller
{
    /**
     * Redirect ke halaman login Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google OAuth.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Login dengan Google gagal. Silakan coba lagi.']);
        }

        // Cari user berdasarkan google_id atau email
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            // Update google_id jika belum tersimpan
            if (!$user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }

            // Update avatar dari Google jika ada
            if ($googleUser->getAvatar()) {
                $user->update(['avatar' => $googleUser->getAvatar()]);
            }
        } else {
            // Buat user baru dari Google
            $user = User::create([
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
                'password'  => null, // login Google tidak punya password
                'role'      => 'customer',
            ]);

            // Buat cart untuk user baru
            $user->cart()->create();
        }

        Auth::login($user, true); // true = remember me

        request()->session()->regenerate();

        return redirect()
            ->route('home')
            ->with('success', 'Berhasil login dengan Google. Selamat datang, ' . $user->name . '!');
    }
}