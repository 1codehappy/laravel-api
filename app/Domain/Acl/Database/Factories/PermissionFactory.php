<?php

namespace App\Domain\Acl\Database\Factories;

use App\Domain\Acl\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
class PermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = Permission::class;

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
}
