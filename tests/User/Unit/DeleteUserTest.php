<?php

namespace Tests\User\Unit;

use App\Domain\User\Actions\DeleteUser;
use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_delete_user()
    {
        $action = new DeleteUser();
        $user = User::factory()->create();
        $this->assertTrue($action->execute($user));
    }
}
