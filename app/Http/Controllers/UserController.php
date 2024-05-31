<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show register/create form
    public function create() {
        return view('Users/register');
    }

    //Create new user
    public function store(Request $request) {
        $formFields = $request->validate([
            'name'=>['required','min:3'],
            'email'=>['required','email',Rule::unique('users', 'email')],
            'password'=>['required', 'confirmed', 'min:6']
        ]);
        
        // Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User and login
        $user = User::create($formFields);
        auth()->login($user);

        return redirect('/home')->with('message', 'User created and logged in');
    }

    // Deny access
    public function accessdenied(Request $request) {
        return view('users/accessdenied');
    }
    // Show login form
    public function login() {
        return view('users/login');
    }

    // Confirm logout 
    public function confirmlogout() {
        return view('users/confirmlogout');
    }

    // Logout user
    public function logout(Request $request) {
        auth()->logout(); 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/home')->with('message', 'Successfully logged out');

    }

    // Authenticate user
    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'email'=>['required','email'],
            'password'=>['required']
        ]);

        if(auth()->attempt($formFields)) {

            # Return to intended url
            if(session('url.intended')){
                return redirect()->to(session('url.intended'))->with('message', 'You are logged in');
            }
            $request->session()->regenerate();
            return redirect('/home')->with('message', 'You are logged in');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
