<?php

namespace App\Support\Auth\DTOs;

use Illuminate\Foundation\Http\FormRequest;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class EmailDto extends CastableDataTransferObject
{
    /**
     * The user's email.
     *
     * @var string
     */
    public string $email;

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
        ]);
    }
}
