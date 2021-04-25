<?php

namespace App\Domain\FailedJob\Database\Seeders;

use App\Domain\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Config::get('failed_job.permission');
        foreach ($permissions as $permission) {
            if (Permission::where('name', $permission)->first()) {
                continue;
            }
            Permission::create(['name' => $permission]);
        }
    }
}
