<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use App\Http\Requests\LoginRequest;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('login');
    }

    public function login(LoginRequest $request)
    {
        // email が未認証の場合はエラー
        $credentials = $request->only('email', 'password');

        $user = \App\Models\User::where('email', $credentials['email'])->first();
        if ($user && is_null($user->email_verified_at)) {
            throw ValidationException::withMessages([
                'email' => 'メール認証が完了していません。メールをご確認ください。',
            ]);
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home')); // 認証後のリダイレクト先
        }

        throw ValidationException::withMessages([
            'email' => 'ログイン情報が登録されていません。',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // トップページに戻る
    }
}

