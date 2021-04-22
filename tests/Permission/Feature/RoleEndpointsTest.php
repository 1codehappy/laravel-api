<?php

namespace Tests\Permission\Feature;

use App\Domain\Permission\Models\Permission;
use App\Domain\Permission\Models\Role;
use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RoleEndpointsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_list_roles()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('roles.read')
        ;
        Role::factory()
            ->count(11)
            ->create()
        ;
        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('GET', '/roles?per_page=10&page=2')
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
        $this->assertArrayHasKey('permissions', $jsonResponse['data'][0]);
    }

    /**
     * @test
     */
    public function it_can_find_roles_by_name()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('roles.read')
        ;
        Role::factory()->create([
            'name' => 'Ola Mundo',
        ]);
        Role::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user),
        ])->json('GET', '/roles' . '?filter[name]=ola m');
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
    public function it_can_sort_roles_by()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('roles.read')
        ;
        Role::factory()
            ->count(10)
            ->create()
        ;
        $orientation = ['', '-'];
        foreach ($orientation as $concat) {
            $response = $this->withHeaders([
                    'Authorization' => 'Bearer ' . Auth::login($user),
                ])
                ->json('GET', "/roles?sort={$concat}name")
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

    /**
     * @test
     */
    public function it_validates_permission_for_listing_roles()
    {
        $user = User::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('GET', '/roles')
        ;
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function it_can_show_the_information_of_the_role()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('roles.read')
        ;
        $role = Role::factory()->create();
        $permissions = Permission::factory()->count(3)->create();
        $role->givePermissionTo($permissions);
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('GET', "/roles/{$role->uuid}")
        ;
        $response
            ->assertHeader('Content-Type', 'application/json')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $role->uuid,
                    'name' => $role->name,
                    'permissions' => $permissions->pluck('uuid')->all(),
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_prevents_show_the_information_of_the_role()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('GET',  "/roles/{$role->uuid}")
        ;
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function it_cannot_find_the_role()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('roles.read')
        ;
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('GET',  "/roles/{$this->faker()->uuid}")
        ;
        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function it_creates_role()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('roles.create')
        ;
        $role = Role::factory()->make();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('POST', '/roles', $role->toArray())
        ;
        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $role->name,
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_prevents_create_role()
    {
        $user = User::factory()->create();
        $role = Role::factory()->make();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('POST', '/roles', $role->toArray())
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
            ->givePermissionTo('roles.create')
        ;
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('POST', '/roles', ['name' => null])
        ;
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_can_update_a_role()
    {
        $user1 = User::factory()
            ->create()
            ->givePermissionTo('roles.update')
        ;
        $role = Role::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user1),
            ])
            ->json('PUT', "/roles/{$role->uuid}", [
                'name' => 'Let it go',
            ])
        ;
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Let it go',
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_validates_input_to_update_a_role()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('roles.update')
        ;
        $role = Role::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('PUT', "/roles/{$role->uuid}", [
                'name' => '',
            ])
        ;
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_can_delete_a_role()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('roles.delete')
        ;
        $role = Role::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('DELETE', "/roles/{$role->uuid}")
        ;
        $response->assertStatus(204);
    }

    /**
     * @test
     */
    public function it_protects_the_role_from_being_deleted_by_user_with_no_permission()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('DELETE', "/roles/{$role->uuid}")
        ;
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function it_can_create_role_with_associated_permissions()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('roles.create')
        ;
        $permissions = Permission::factory()
            ->count(2)
            ->create()
        ;
        $roleName = $this->faker()->name;
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('POST', '/roles', [
                'name' => $roleName,
                'permissions' => $permissions->pluck('name')->toArray(),
            ])
        ;
        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $roleName,
                    'permissions' => $permissions->pluck('uuid')->toArray(),
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_updates_role_permissions()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('roles.update')
        ;
        $permissions = Permission::factory()
            ->count(2)
            ->create()
        ;
        $role = Role::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('PUT', "/roles/{$role->uuid}", [
                'permissions' => $permissions->pluck('name')->toArray(),
            ])
        ;
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'permissions' => $permissions->pluck('uuid')->toArray(),
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_deletes_role_permissions_if_empty_array_sent()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('roles.update')
        ;
        $permissions = Permission::factory()
            ->count(2)
            ->create()
        ;
        $role = Role::factory()->create()->givePermissionTo($permissions);
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('PUT', "/roles/{$role->uuid}", [
                'permissions' => [],
            ])
        ;
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'permissions' => [],
                ],
            ])
        ;
    }
}
