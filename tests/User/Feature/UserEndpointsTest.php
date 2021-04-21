<?php

namespace Tests\User\Feature;

use App\Domain\Permission\Models\Permission;
use App\Domain\Permission\Models\Role;
use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserEndpointsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_list_users()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('users.read')
        ;
        User::factory()
            ->count(10)
            ->create()
        ;
        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('GET', '/users?per_page=10&page=2')
        ;
        $response
            ->assertHeader('Content-Type', 'application/json')
            ->assertStatus(200)
        ;
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $jsonResponse);
        $this->assertArrayHasKey('meta', $jsonResponse);
        $this->assertArrayHasKey('pagination', $jsonResponse['meta']);
        $this->assertEquals(11, $jsonResponse['meta']['pagination']['total']);
        $this->assertEquals(1, $jsonResponse['meta']['pagination']['count']);
        $this->assertCount(1, $jsonResponse['data']);
        $this->assertArrayHasKey('id', $jsonResponse['data'][0]);
        $this->assertArrayHasKey('name', $jsonResponse['data'][0]);
        $this->assertArrayHasKey('email', $jsonResponse['data'][0]);
        $this->assertArrayHasKey('roles', $jsonResponse['data'][0]);
        $this->assertArrayHasKey('permissions', $jsonResponse['data'][0]);
    }

    /**
     * @test
     */
    public function it_can_find_users_by_name()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('users.read')
        ;
        User::factory()->create([
            'name' => 'John Doe',
        ]);
        User::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user),
        ])->json('GET', '/users' . '?filter[name]=john d');
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $jsonResponse);
        $this->assertArrayHasKey('meta', $jsonResponse);
        $this->assertArrayHasKey('pagination', $jsonResponse['meta']);
        $this->assertEquals(1, $jsonResponse['meta']['pagination']['total']);
    }

    /**
     * @test
     */
    public function it_can_find_users_by_email()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('users.read')
        ;
        User::factory()->create([
            'email' => 'john.smith@example.com',
        ]);
        User::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user),
        ])->json('GET', '/users' . '?filter[email]=john.smith@example.com');
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $jsonResponse);
        $this->assertArrayHasKey('meta', $jsonResponse);
        $this->assertArrayHasKey('pagination', $jsonResponse['meta']);
        $this->assertEquals(1, $jsonResponse['meta']['pagination']['total']);
    }

    /**
     * @test
     */
    public function it_cannot_find_users_by_email_part()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('users.read')
        ;
        User::factory()->create([
            'email' => 'john2.smith@example.com',
        ]);
        User::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user),
        ])->json('GET', '/users' . '?filter[email]=john2');
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $jsonResponse);
        $this->assertArrayHasKey('meta', $jsonResponse);
        $this->assertArrayHasKey('pagination', $jsonResponse['meta']);
        $this->assertEquals(0, $jsonResponse['meta']['pagination']['total']);
    }

    /**
     * @test
     */
    public function it_can_sort_users_by()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('users.read')
        ;
        User::factory()
            ->count(10)
            ->create()
        ;
        $sortedFields = ['name', 'created_at'];
        $orientation = ['', '-'];
        foreach ($sortedFields as $sortedField) {
            foreach ($orientation as $concat) {
                $response = $this->withHeaders([
                        'Authorization' => 'Bearer ' . Auth::login($user),
                    ])
                    ->json('GET', "/users?sort={$concat}{$sortedField}")
                ;
                $response
                    ->assertHeader('Content-Type', 'application/json')
                    ->assertStatus(200);
                $jsonResponse = json_decode($response->getContent(), true);
                $this->assertArrayHasKey('data', $jsonResponse);
                $this->assertArrayHasKey('meta', $jsonResponse);
                $this->assertArrayHasKey('pagination', $jsonResponse['meta']);
            }
        }
    }

    /**
     * @test
     */
    public function it_validates_permission_for_listing_users()
    {
        $user = User::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('GET', '/users')
        ;
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function it_can_show_the_information_of_the_user()
    {
        $user1 = User::factory()
            ->create()
            ->givePermissionTo('users.read')
        ;
        $user2 = User::factory()->create();
        $roles = Role::factory()->count(2)->create();
        $user2->assignRole($roles);
        $permissions = Permission::factory()->count(3)->create();
        $user2->givePermissionTo($permissions);
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user1),
            ])
            ->json('GET', "/users/{$user2->uuid}")
        ;
        $response
            ->assertHeader('Content-Type', 'application/json')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $user2->uuid,
                    'name' => $user2->name,
                    'email' => $user2->email,
                    'roles' => $roles->pluck('uuid')->all(),
                    'permissions' => $permissions->pluck('uuid')->all(),
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_prevents_show_the_information_of_the_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user1),
            ])
            ->json('GET',  "/users/{$user2->uuid}")
        ;
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function it_cannot_find_the_user()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('users.read')
        ;
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('GET',  "/users/{$this->faker()->uuid}")
        ;
        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function it_creates_user()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('users.create')
        ;
        $newUser = User::factory()->make();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('POST', '/users', $newUser->toArray())
        ;
        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $newUser->name,
                    'email' => $newUser->email,
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_prevents_create_user()
    {
        $user = User::factory()->create();
        $newUser = User::factory()->make();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('POST', '/users', $newUser->toArray())
        ;
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function it_validates_input_for_creation()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('users.create');
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('POST', '/users', [
                'name' => 'Some User',
                'email' => 'some@email.com',
                'password' => '123456789qq',
            ])
        ;
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_can_partially_update_a_user()
    {
        $user1 = User::factory()
            ->create()
            ->givePermissionTo('users.update')
        ;
        $user2 = User::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user1),
            ])
            ->json('PUT', "/users/{$user2->uuid}", [
                'name' => 'John Doe',
            ])
        ;
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'John Doe',
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_can_update_a_user()
    {
        $user1 = User::factory()
            ->create()
            ->givePermissionTo('users.update')
        ;
        $user2 = User::factory()->create();
        $email = $this->faker()->safeEmail;
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user1),
            ])
            ->json('PUT', "/users/{$user2->uuid}", [
                'name' => 'John Doe',
                'email' => $email,
            ])
        ;
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'John Doe',
                    'email' => $email,
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_validates_input_to_update_a_user()
    {
        $user1 = User::factory()
            ->create()
            ->givePermissionTo('users.update')
        ;
        $user2 = User::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user1),
            ])
            ->json('PUT', "/users/{$user2->uuid}", [
                'name' => '',
            ])
        ;
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_validates_taken_email()
    {
        $user1 = User::factory()
            ->create()
            ->givePermissionTo('users.update')
        ;
        $user2 = User::factory()->create();
        User::factory()->create(['email' => 'some@email.com']);
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user1),
            ])
            ->json('PUT', "/users/{$user2->uuid}", [
                'email' => 'some@email.com',
            ])
        ;
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_validates_input_to_update_a_user_full_entity()
    {
        $user1 = User::factory()
            ->create()
            ->givePermissionTo('users.update')
        ;
        $user2 = User::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user1),
            ])
            ->json('PUT', "/users/{$user2->uuid}", [
                'name' => 'Some Name',
                'email' => '',
            ])
        ;
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_can_delete_a_user()
    {
        $user1 = User::factory()
            ->create()
            ->givePermissionTo('users.delete')
        ;
        $user2 = User::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user1),
            ])
            ->json('DELETE', "/users/{$user2->uuid}")
        ;
        $response->assertStatus(204);
    }

    /**
     * @test
     */
    public function it_protects_the_user_from_being_deleted_by_user_with_no_permission()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user1),
            ])
            ->json('DELETE', "/users/{$user2->uuid}")
        ;
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function it_can_create_user_with_associated_role()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('users.create')
        ;
        $roles = Role::factory()
            ->count(2)
            ->create()
        ;
        $email = $this->faker()->safeEmail;
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('POST', '/users', [
                'name' => 'John Doe',
                'email' => $email,
                'password' => '12345678',
                'password_confirmation' => '12345678',
                'roles' => $roles->pluck('name')->toArray(),
            ])
        ;
        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'John Doe',
                    'email' => $email,
                    'roles' => $roles->pluck('uuid')->toArray(),
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_updates_users_roles()
    {
        $user1 = User::factory()
            ->create()
            ->givePermissionTo('users.update')
        ;
        $roles = Role::factory()
            ->count(2)
            ->create()
        ;
        $user2 = User::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user1),
            ])
            ->json('PUT', "/users/{$user2->uuid}", [
                'roles' => $roles->pluck('name')->toArray(),
            ])
        ;
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'roles' => $roles->pluck('uuid')->toArray(),
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_deletes_users_roles_if_empty_array_sent()
    {
        $user1 = User::factory()
            ->create()
            ->givePermissionTo('users.update')
        ;
        $roles = Role::factory()
            ->count(2)
            ->create()
        ;
        $user2 = User::factory()->create()->assignRole($roles);
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user1),
            ])
            ->json('PUT', "/users/{$user2->uuid}", [
                'roles' => [],
            ])
        ;
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'roles' => [],
                ],
            ])
        ;
    }
}
