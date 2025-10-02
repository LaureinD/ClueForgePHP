<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request) {
        //todo: add strong password check (min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\d\W])$/)
        $fields = $request->validate([
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'acceptTerms' => 'required|accepted'
        ], [
            'avatar.image' => 'Only images are accepted.',
            'avatar.mimes' => 'Only images are accepted.',
            'avatar.max' => 'File exceeds 2MB size limit.',
        ]);

        $fields['first_name'] = ucfirst(strtolower($fields['first_name']));
        $fields['last_name'] = ucfirst(strtolower($fields['last_name']));

        $user = User::create($fields);

        $file = $request->file('avatar');
        if ($file) {
            $storagePath = $file->store('img/avatars', 'public');
            $fileType = $file->getClientMimeType();
            $fileSize = $file->getSize();

            $user->images()->create([
                'path' => $storagePath,
                'alt' => 'avatar '.$fields['first_name'].' '.$fields['last_name'],
                'type' => $fileType,
                'size' => $fileSize,
                'is_primary' => true,
            ]);
        }

        //todo: add email confirmation
        Auth::login($user);

        return redirect()
                ->route('admin.dashboard')
                ->with('success',['message' => "Welcome $user->first_name, \n Your account was created successfully!",]);
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
                return redirect()
                        ->route('admin.dashboard')
                        ->with('success',['message' => "Welcome ".Auth()->user()?->first_name.", \n Successfully logged in to the admin panel!",]);

            } else {
                return redirect()
                        ->route('app.dashboard')
                        ->with('success',['message' => "Welcome ".Auth()->user()?->first_name.", \n Successfully logged in to ClueForge!",]);

            }
        }

        return back()->withErrors(['email' => 'The provided credentials don\'t match our records.'])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
