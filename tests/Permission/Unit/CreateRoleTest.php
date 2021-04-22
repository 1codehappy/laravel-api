<?php

namespace Tests\Permission\Unit;

use App\Domain\Permission\Actions\CreateRole;
use App\Domain\Permission\Models\Role;
use App\Support\Permission\DTOs\RoleDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateRoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_create_new_Role()
    {
        $action = new CreateRole();
        $Role = $action->execute(new RoleDto(Role::factory()->make()->toArray()));
        $this->assertInstanceOf(Role::class, $Role);
    }
}
