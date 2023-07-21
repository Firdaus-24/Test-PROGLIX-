<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->stateless()->user();
            // $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);

                // return redirect()->intended('dashboard');
                return response()->json($finduser);
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'name' => $user->name,
                    'google_id' => $user->id,
                    'password' => Hash::make('password')
                ]);

                Auth::login($newUser);

                return response()->json($newUser);
                // return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => true,
            'massage' => 'Berhasil logout'
        ], 200);
    }
}
