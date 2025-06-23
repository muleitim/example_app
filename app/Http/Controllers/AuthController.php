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
            'password' => ['required', 'min:6', 'confirmed']
        ]);       

        // register
        $user = User::create($fields);        

        // login 
        Auth::login($user);

        // redirect
        return redirect()->route('home');
    }

    // Login User 
    public function Login(Request $request)
    {
        // validate
        $fields = $request->validate([            
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required']
        ]);     

        // try to login the user
        if( Auth::attempt($fields, $request->remember) )
        {
            return redirect()->intended('dashboard');
        }
        else 
        {
            return back()->withErrors([
                'failed' => 'Invalid login credentials'
            ]);
        }
    }

    // Log out user 
    public function logout(Request $request)
    {
        //Logout the user
        Auth::logout();

        // invalidate user's session
        $request->session()->invalidate();

        // regenerate CSRF token
        $request->session()->regenerateToken();
        
        // redirect to home
        return redirect('/');
    }

}
