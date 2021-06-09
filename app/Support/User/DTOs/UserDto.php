<?php

namespace App\Support\User\DTOs;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UserDto extends DataTransferObject
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
     * The timestamp of email verification
     *
     * @var string|null
     */
    public ?string $email_verified_at;

    /**
     * The roles of user
     *
     * @var array|null
     */
    public ?array $roles;

    /**
     * The permissions of user
     *
     * @var array|null
     */
    public ?array $permissions;

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
            'roles' => $request->get('roles'),
            'permissions' => $request->get('permissions'),
        ]);
    }
}
