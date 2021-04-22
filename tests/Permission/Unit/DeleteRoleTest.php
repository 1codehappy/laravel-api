<?php

namespace Tests\Permission\Unit;

use App\Domain\Permission\Actions\DeleteRole;
use App\Domain\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteRoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_delete_Role()
    {
        $action = new DeleteRole();
        $Role = Role::factory()->create();
        $this->assertTrue($action->execute($Role));
    }
}
