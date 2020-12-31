<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware(['guest']);
    }

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
        $userData = $request->only('email', 'password');
        $auth = auth()->attempt($userData, $request->remember);

        if(!$auth)
        {
            return back()->with('status', 'Invalid login details');
        }

        // Redirect
        return redirect()->route('dashboard');
    }
}
