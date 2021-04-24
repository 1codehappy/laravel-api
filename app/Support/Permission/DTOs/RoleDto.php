<?php

namespace App\Support\Permission\DTOs;

use App\Support\Contracts\DTOs\Item;
use Illuminate\Foundation\Http\FormRequest;

class RoleDto extends Item
{
    /**
     * The role's name
     *
     * @var string|null
     */
    public ?string $name;

    /**
     * The guard's name of role
     *
     * @var string|null
     */
    public ?string $guard_name;

    /**
     * The role's permissions
     *
     * @var array|null
     */
    public ?array $permissions;

    /**
     * Check this role has permissions
     *
     * @return bool
     */
    public function hasPermissions(): bool
    {
        return is_array($this->permissions) && count($this->permissions) > 0;
    }

    /**
     * Create dto from request
     *
     * @param FormRequest $request
     * @return self
     */
    public static function fromRequest(FormRequest $request): self
    {
        return new self([
            'name' => $request->get('name'),
            'permissions' => $request->get('permissions'),
        ]);
    }
}
