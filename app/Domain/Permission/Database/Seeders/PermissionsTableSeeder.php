<?php

namespace App\Domain\Permission\Database\Seeders;

use App\Domain\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Permissions
     *
     * @var array
     */
    protected array $permissions = [
        'permissions.read',
        'roles.create',
        'roles.read',
        'roles.update',
        'roles.delete',
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
