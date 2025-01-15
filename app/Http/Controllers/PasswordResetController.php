<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PasswordResetController extends Controller
{
    /**
     * Handle password reset request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'username' => 'required|string|exists:users,username',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Find the user by username
        $user = User::where('username', $validated['username'])->first();

        if (!$user) {
            smilify('error', 'No user with such email found.');
            return back();
            // response()->json([
            //     'message' => 'User not found',
            // ], 404);
        }

        // Update the user's password
        $user->password = Hash::make($validated['password']);
        $user->save();

        smilify('success', 'Password reset successfully.');
        return redirect("/login");
        // response()->json([
        //     'message' => 'Password reset successfully',
        // ], 200);
    }

    public function forgottenPassword()
    {
        return view('auth.reset-password');
    }
    //
}
