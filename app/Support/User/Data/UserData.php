<?php

namespace App\Support\User\Data;

use App\Support\Contracts\DataTransferObjects\Item;
use Illuminate\Foundation\Http\FormRequest;

class UserData extends Item
{
    /**
     * The user's name
     *
     * @var string|null
     */
    public ?string $name;

    /**
     * The user's email
     *
     * @var string|null
     */
    public ?string $email;

    /**
     * The user's password
     *
     * @var string|null
     */
    public ?string $password;

    /**
     * Create data from request
     *
     * @param FormRequest $request
     * @return self
     */
    public static function fromRequest(FormRequest $request): self
    {
        return new self([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);
    }
}
