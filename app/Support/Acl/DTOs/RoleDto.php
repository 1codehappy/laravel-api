<?php

namespace App\Support\Acl\DTOs;

use Illuminate\Foundation\Http\FormRequest;
use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class RoleDto extends CastableDataTransferObject
{
    /** @var string|null The name of role. */
    public ?string $name;

    /** @var string|null The name of auth guard. */
    public ?string $guard_name;

    /** @var string[]|null The permissions of the user. */
    public ?array $permissions;

    /**
     * Check if the role has permissions.
     *
     * @return bool
     */
    public function hasPermissions(): bool
    {
        return is_array($this->permissions) && count($this->permissions) > 0;
    }

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
            'permissions' => $request->get('permissions'),
        ]);
    }
}
