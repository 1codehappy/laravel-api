<?php

namespace App\Domain\User\Database\Seeders;

use App\Domain\Permission\Models\Permission;
use App\Domain\User\Models\User;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * User permissions
     *
     * @var array
     */
    protected array $permissions = [
        'users.create',
        'users.read',
        'users.update',
        'users.delete',
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->permissions as $permission) {
            if (Permission::where('name', $permission)->first()) {
                continue;
            }
            Permission::create(['name' => $permission]);
        }
    }
}
