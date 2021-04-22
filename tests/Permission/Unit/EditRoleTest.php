<?php

namespace Tests\Permission\Unit;

use App\Domain\Permission\Actions\EditRole;
use App\Domain\Permission\Models\Role;
use App\Support\Permission\DTOs\RoleDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditRoleTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_can_update_Role_data()
    {
        $action = new EditRole();
        $Role = Role::factory()->create();
        $oldName = $Role->name;
        $newName = $this->faker()->name;
        $Role = $action->execute(new RoleDto(['name' => $newName]), $Role);
        $this->assertInstanceOf(Role::class, $Role);
        $this->assertNotEquals($oldName, $Role->name);
    }
}
