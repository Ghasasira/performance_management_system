<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:users,username',
        ]);

        dd("we here");

        $user = User::where('username', $request->username)->first();
        dd("we here");

        if ($user) {
            Password::broker()->sendResetLink(
                ['email' => $user->username] // Send reset email to user's email
            );

            return back()->with('status', 'Password reset link sent!');
        }

        return back()->withErrors(['username' => 'No user found with this username.']);
    }
    //
}
