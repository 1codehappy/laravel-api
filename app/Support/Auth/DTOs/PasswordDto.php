<?php

namespace App\Support\Auth\DTOs;

use Illuminate\Foundation\Http\FormRequest;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class PasswordDto extends CastableDataTransferObject
{
    /**
     * The token to reset the password.
     *
     * @var string
     */
    public string $token;

    /**
     * The user's email.
     *
     * @var string
     */
    public string $email;

    /**
     * The new password of the user.
     *
     * @var string
     */
    public string $password;

    /**
     * The password confirmation to validate.
     *
     * @var string
     */
    public string $password_confirmation;

    /**
     * Create dto from a request.
     *
     * @param FormRequest $request
     * @return self
     */
    public static function fromRequest(FormRequest $request): self
    {
        return new self([
            'token' => $request->get('token'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'password_confirmation' => $request->get('password_confirmation'),
        ]);
    }
}
