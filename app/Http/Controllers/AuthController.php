<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        //todo: add strong password check (min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\d\W])$/)
        $fields = $request->validate([
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'acceptTerms' => 'required|accepted'
        ]);

        $fields['first_name'] = ucfirst(strtolower($fields['first_name']));
        $fields['last_name'] = ucfirst(strtolower($fields['last_name']));

        $user = User::create($fields);

        //todo: add email confirmation
        Auth::login($user);

        //todo: add proper role/permission check
        if ($user->id === 1) {
            return redirect()->route('admin.dashboard');

        } else {
            return redirect()->route('app.dashboard');

        }
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($fields, $request->rememberMe)) {
            $request->session()->regenerate();

            //todo: add proper role/permission check
            if (Auth()->user()?->id === 1) {
                return redirect()->route('admin.dashboard');

            } else {
                return redirect()->route('app.dashboard');

            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials don\'t match our records.'
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
