<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            [
                'google_user_id' => $googleUser->id
            ],
            [
                'name' => $googleUser->name, 
                'email' => $googleUser->email,
                'password' => Hash::make('password@Password!'),
                'google_user_id' => $googleUser->id,
                'email_verified_at' => now(),
            ]
        );
        
        Auth::login($user);
        if ($user->role == 1) {
            return redirect(route('admin.dashboard'));
        }
        return redirect(route('client.cars.home', absolute: false));
    }
}
