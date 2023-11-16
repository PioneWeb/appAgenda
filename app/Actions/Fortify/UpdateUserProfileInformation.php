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
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nome' => ['required', 'string', 'max:255'],
            'cognome' => ['required', 'string', 'max:255'],
            'indirizzo' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],
            'cellulare' => ['required', 'string', 'max:255'],
            'ragione_sociale' => ['required', 'string', 'max:255'],
            'p_iva' => ['required', 'string', 'max:11'],
            'c_fiscale' => ['required', 'string', 'max:16'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'nome' => $input['nome'],
                'cognome' => $input['cognome'],
                'indirizzo' => $input['indirizzo'],
                'telefono' => $input['telefono'],
                'cellulare' => $input['cellulare'],
                'ragione_sociale' => $input['ragione_sociale'],
                'p_iva' => $input['p_iva'],
                'c_fiscale' => $input['c_fiscale'],
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
            'name' => $input['name'],
            'email' => $input['email'],
            'nome' => $input['nome'],
            'cognome' => $input['cognome'],
            'indirizzo' => $input['indirizzo'],
            'telefono' => $input['telefono'],
            'cellulare' => $input['cellulare'],
            'ragione_sociale' => $input['ragione_sociale'],
            'p_iva' => $input['p_iva'],
            'c_fiscale' => $input['c_fiscale'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
