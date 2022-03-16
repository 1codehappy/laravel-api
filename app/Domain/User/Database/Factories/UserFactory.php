<?php

namespace App\Domain\User\Database\Factories;

use App\Domain\Acl\Models\Permission;
use App\Domain\Acl\Models\Role;
use App\Domain\User\Models\User;
use App\Support\Core\Contracts\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = User::class;

    /** @var int */
    protected int $numberOfRoles = 0;

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
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return static
     */
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            if ($this->numberOfRoles > 0) {
                $roles = Role::factory()
                    ->hasPermissions()
                    ->count($this->numberOfRoles)
                    ->create();
                $user->assignRole($roles->pluck('name')->all());
            }
            if ($this->numberOfPermissions > 0) {
                $permissions = Permission::factory()
                    ->count($this->numberOfPermissions)
                    ->create();
                $user->givePermissionTo($permissions->pluck('name')->all());
            }
            $user->load('roles', 'permissions');
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return Factory
     */
    public function unverified()
    {
        return $this->state(fn () => ['email_verified_at' => null]);
    }

    /**
     * Indicate that the user has roles.
     *
     * @param int $quantity
     * @return Factory
     */
    public function hasRoles(int $quantity = 0): Factory
    {
        $this->numberOfRoles = $quantity ?: $this->faker->numberBetween(1, 4);

        return $this->state(fn () => []);
    }

    /**
     * Indicate that the user has permissions.
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
