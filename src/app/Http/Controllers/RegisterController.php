<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    public function showForm()
    {
        return view('register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        
        Auth::login($user); 

        event(new Registered($user));
        
        return redirect()->route('verification.notice'); 
    }
}