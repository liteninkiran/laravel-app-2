<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Validate
        $validationRules =
        [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $this->validate($request, $validationRules);

        // Authenticate user
        if(!auth()->attempt($request->only('email', 'password')))
        {
            return back()->with('status', 'Invalid login details');
        }

        // Redirect
        return redirect()->route('dashboard');
    }
}
