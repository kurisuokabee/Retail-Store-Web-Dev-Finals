<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
       $credentials = $request->validate([
           'email' => 'required|email',
           'password' => 'required|min:3',
       ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('customer_id', Auth::user()->customer_id);
            return redirect()->intended(route('products.browse'));
        }

        return back()->withErrors([
            'message' => 'Invalid credentials.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
       $data = $request->validate([
            'username' => 'required|string|max:255|unique:customers,username',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6',
        ]);

        $user = Customer::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'first_name' => '',
            'last_name' => '',
            'date_of_birth' => now()->format('Y-m-d'),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('products.browse');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
