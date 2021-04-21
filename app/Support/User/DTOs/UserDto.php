<?php

namespace App\Support\User\DTOs;

use App\Support\Contracts\DTOs\Item;
use Illuminate\Foundation\Http\FormRequest;

class UserDto extends Item
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
