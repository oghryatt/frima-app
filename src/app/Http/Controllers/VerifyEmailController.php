<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            
            return redirect()->route('mypage.profile.setup'); 
        }

        
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        
        
        return redirect()->route('mypage.profile.setup')->with('verified', true);
    }
}