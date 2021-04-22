<?php

namespace Tests\User\Unit;

use App\Domain\User\Actions\EditUser;
use App\Domain\User\Models\User;
use App\Support\User\DTOs\UserDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditUserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_can_update_user_data()
    {
        $action = new EditUser();
        $user = User::factory()->create();
        $oldName = $user->name;
        $newName = $this->faker()->name;
        $user = $action->execute(new UserDto(['name' => $newName]), $user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertNotEquals($oldName, $user->name);
    }
}
