<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validate
        $validationRules =
        [
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed',
        ];

        $this->validate($request, $validationRules);

        // Store user
        $data =
        [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        User::create($data);

        // Authenticate user
        auth()->attempt($request->only('email', 'password'));

        // Redirect
        return redirect()->route('dashboard');
    }
}
