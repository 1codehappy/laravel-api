<?php

namespace App\Domain\Acl\Database\Factories;

use App\Domain\Acl\Models\Permission;
use App\Domain\Acl\Models\Role;
use App\Support\Core\Contracts\Factories\Factory;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = Role::class;

    /** @var int */
    protected int $numberOfPermissions = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return static
     */
    public function configure()
    {
        return $this->afterCreating(function (Role $role) {
            if ($this->numberOfPermissions > 0) {
                $permissions = Permission::factory()
                    ->count($this->numberOfPermissions)
                    ->create();
                $role->givePermissionTo($permissions->pluck('name')->all());
                $role->load('permissions');
            }
        });
    }

    /**
     * Indicate that the role has permissions.
     *
     * @param int $quantity
     * @return Factory
     */
    public function hasPermissions(int $quantity = 0): Factory
    {
        $this->numberOfPermissions = $quantity ?: $this->faker->numberBetween(1, 4);

        return $this->state(fn () => []);
    }
}
