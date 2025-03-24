<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $providerUser = Socialite::driver($provider)->user();
        dd($providerUser);
 
        // $user = User::updateOrCreate([
        //     'github_id' => $providerUser->id,
        // ], [
        //     'name' => $providerUser->name,
        //     'email' => $providerUser->email,
        //     'github_token' => $providerUser->token,
        //     'github_refresh_token' => $providerUser->refreshToken,
        // ]);
    
        // Auth::login($user);
    
        // return redirect('/dashboard');
    }
}
