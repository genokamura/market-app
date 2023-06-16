<?php

namespace App\Http\Controllers\User;

use App\Events\EmailAddressChanged;
use App\Events\FullRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        if ($request->user()->isDirty('email')) {
            throw new \Exception('Email address cannot be changed here.');
        }

        $isFullRegisterAction = !$request->user()->replicate()->isFullRegistered();

        $request->user()->fill($request->validated());
        $request->user()->save();

        if ($isFullRegisterAction) {
            event(new FullRegistered($request->user()));
            return Redirect::route('register.complete');
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', Rule::unique(User::class)->ignore($request->user()->id)],
        ]);

        $request->user()->fill($request->only('email'));
        $request->user()->email_verified_at = null;
        if (!$request->user()->isDirty('email')) {
            return Redirect::route('profile.edit');
        }

        $request->user()->save();

        event(new EmailAddressChanged($request->user()));

        return Redirect::route('profile.edit')->with('status', 'email-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
