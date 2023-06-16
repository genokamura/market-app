<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->isFullRegistered()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        $request->user()->markEmailAsVerified();

        if ($request->user()->hasVerifiedEmail()) {
            return redirect(RouteServiceProvider::FULL_REGISTRATION);
        }

        return redirect(RouteServiceProvider::FULL_REGISTRATION);
    }

    public function update(EmailVerificationRequest $request): RedirectResponse
    {
        $request->user()->markEmailAsVerified();

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
