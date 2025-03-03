<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            "last_name" => ['required', 'string', 'max:255'],
            'username' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->userId)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            "department" => ['required', 'string', 'max:255'],
            // "sub_department"=>['required', 'string', 'max:255'],
            "role" => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if (
            $input['username'] !== $user->username &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'firstName' => $input['first_name'],
                'lastName' => $input['last_name'],
                'username' => $input['username'],
                'department' => $input['department'],
                // 'sub_department'=>$input['sub_department'],
                'role' => $input['role']


            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            // 'name' => $input['name'],
            'username' => $input['username'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
