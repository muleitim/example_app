<?php

namespace App\Http\Controllers;

use App\Events\UserSubscribed;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

        event(new Registered($user));
        // redirect
        return redirect()->route('dashboard');
        
        // the above was 'posts.index'
    }

    // verify email notice handler
    public function verifyNotice()
    {
        return view('auth.verify-email');
    }

    // email verification handler
    public function verifyEmail (EmailVerificationRequest $request) {
        $request->fulfill();    
        return redirect()->route('dashboard');
    }

    // Resending the Verification Email 
    public function verifyHandler (Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return back()->with('message', 'Verification link sent!');
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
