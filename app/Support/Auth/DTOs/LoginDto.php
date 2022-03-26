<?php

namespace App\Support\Auth\DTOs;

use Illuminate\Foundation\Http\FormRequest;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class LoginDto extends CastableDataTransferObject
{
    /**
     * The user's email.
     *
     * @var string
     */
    public string $email;

    /**
     * The user's password.
     *
     * @var string
     */
    public string $password;

    /**
     * Create dto from a request.
     *
     * @param FormRequest $request
     * @return self
     */
    public static function fromRequest(FormRequest $request): self
    {
        return new self([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);
    }
}
