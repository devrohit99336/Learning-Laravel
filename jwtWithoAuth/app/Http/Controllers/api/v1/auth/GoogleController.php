<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        try {
            //return Socialite::driver('google')->scopes(['profile', 'email'])->redirect();
            return Socialite::driver('google')->redirect();
            //return response()->json(['message' => 'Google login is not implemented yet.']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                // if you are using laravel passport
                // Auth::login($finduser);
                // return redirect()->intended('dashboard');

                // if you are using jwt
                $token = JWTAuth::fromUser($finduser);
                return response()->json(compact('finduser', 'token'));
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('password')
                ]);

                // if you are using laravel passport
                // Auth::login($newUser);
                // return redirect()->intended('dashboard');

                // if you are using jwt
                $token = JWTAuth::fromUser($newUser);
                return response()->json(compact('newUser', 'token'));
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
