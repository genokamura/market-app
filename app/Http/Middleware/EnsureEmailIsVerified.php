<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified as Middleware;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureEmailIsVerified extends Middleware
{
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (! $request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
            ! $request->user()->hasVerifiedEmail())) {
            if ($request->expectsJson()) {
                return abort(403, 'Your email address is not verified.');
            } else if (!$request->user()->isFullRegistered()) {
                return Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice'));
            } else if (!$request->user()->hasVerifiedEmail()) {
                return Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice.update'));
            }
        }

        return $next($request);
    }
}

