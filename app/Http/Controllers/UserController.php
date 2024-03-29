<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Show Register/Create Form
    public function create()
    {
        return view('users.registration');
    }

    //Create New User
    public function store(Request $request)
    {
        $formFields = $request->validate(
            [
                'name' => ['required', 'min:5'],
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => 'required|confirmed|min:6'
            ]
        );
        //Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        //Create User
        $user = User::create($formFields);

        //Login
        auth()->login($user);

        return redirect('dashboard/main')->with('message', 'Welcome, ' . $formFields['name']);
    }

    //Login
    public function login()
    {
        return view('users.login');
    }

    //Authenticate User
    public function authenticate(Request $request)
    {
        $formFields = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => 'required'
            ]
        );

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/dashboard/main')->with('message', 'Welcome back, ' . auth()->user()->name);
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    //Logout User
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect('/login')->with('message', 'You have been logged out.');
    }
}
