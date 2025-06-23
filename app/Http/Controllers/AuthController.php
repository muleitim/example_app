<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // register user
    public function register(Request $request)
    {
        // validate
        $fields = $request->validate([
            'username' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);       

        // register
        $user = User::create($fields);        

        // login 
        Auth::login($user);

        // redirect
        return redirect()->route('home');

    }
}
