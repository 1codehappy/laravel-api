<?php

namespace Tests\User\Unit;

use App\Domain\User\Actions\CreateUser;
use App\Domain\User\Models\User;
use App\Support\User\DTOs\UserDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_create_new_user()
    {
        $action = new CreateUser();
        $user = $action->execute(new UserDto(User::factory()->make()->toArray()));
        $this->assertInstanceOf(User::class, $user);
    }
}
