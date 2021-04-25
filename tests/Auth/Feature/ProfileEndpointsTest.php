<?php

namespace Tests\Auth\Feature;

use App\Domain\User\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProfileEndpointsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_gets_user_profile()
    {
        $user = User::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user),
        ])->json('GET', '/auth/me');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('uuid')->toArray(),
                'permissions' => $user->roles->pluck('permissions')->toArray(),
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_can_update_logged_user_profile_all_entity()
    {
        $user = User::factory()->create();
        $userNewData = User::factory()->make();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user),
        ])->json('PUT', '/auth/me', [
            'name' => $userNewData->name,
            'email' => $userNewData->email,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => $userNewData->name,
            'email' => $userNewData->email,
        ]);
        $response->assertJson([
            'data' => [
                'id' => $user->uuid,
                'name' => $userNewData->name,
                'email' => $userNewData->email,
                'roles' => [],
                'permissions' => [],
            ]
        ]);
    }

    /**
     * @test
     */
    public function it_can_update_profile_partial_entity()
    {
        $user = User::factory()->create();
        $userNewData = User::factory()->make();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user),
        ])->json('PUT', '/auth/me', [
            'name' => $userNewData->name,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'name' => $userNewData->name,
            'email' => $user->email,
        ]);
        $response->assertJson([
            'data' => [
                'id' => $user->uuid,
                'name' => $userNewData->name,
                'email' => $user->email,
                'roles' => [],
                'permissions' => [],
            ]
        ]);
    }

    /**
     * @test
     */
    public function it_validates_input_for_update_profile()
    {
        $user = User::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user),
        ])->json('PUT', '/auth/me', [
            'name' => '',
        ]);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_validates_input_for_email_on_update_profile()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user1),
        ])->json('PUT', '/auth/me', [
            'email' => $user2->email,
        ]);
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_updates_logged_in_user_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret1234'),
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user),
        ])->json('PUT', '/auth/me/password', [
            'password' => '123456789qq',
            'password_confirmation' => '123456789qq'
        ]);
        $response->assertStatus(200);
        $this->assertTrue(
            app(Hasher::class)->check('123456789qq', $user->fresh()->password)
        );
    }

    /**
     * @test
     */
    public function it_validates_input_to_update_logged_in_user_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret1234'),
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user),
        ])->json('PUT', '/auth/me/password', [
            'password' => '12345',
            'password_confirmation' => '123456789qq'
        ]);
        $response->assertStatus(422);
        $this->assertFalse(
            app(Hasher::class)->check('123456789qq', $user->fresh()->password)
        );
    }
}
