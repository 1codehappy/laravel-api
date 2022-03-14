<?php

namespace App\Support\User\DTOs;

use Illuminate\Foundation\Http\FormRequest;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class UserDto extends CastableDataTransferObject
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
     * The user's password.
     *
     * @var string|null
     */
    public ?string $password;

    /** @var string[]|null The roles of the user. */
    public ?array $roles;

    /** @var string[]|null The permissions of the user. */
    public ?array $permissions;

    /**
     * Create dto from a request.
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
            'roles' => $request->get('roles'),
            'permissions' => $request->get('permissions'),
        ]);
    }
}
