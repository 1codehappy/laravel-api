<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('paginates the user list.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.viewAny');

    User::factory()
        ->count(5)
        ->create();
    $response = $this->withHeaders(authHeader($user))
        ->get('/users?per_page=5&page=2');
    $response->assertStatus(200);
    $jsonResponse = json_decode($response->getContent(), true);
    $this->assertArrayHasKey('data', $jsonResponse);
    $this->assertArrayHasKey('meta', $jsonResponse);
    $this->assertArrayHasKey('pagination', $jsonResponse['meta']);
    $this->assertEquals(6, $jsonResponse['meta']['pagination']['total']);
    $this->assertEquals(1, $jsonResponse['meta']['pagination']['count']);
    $this->assertCount(1, $jsonResponse['data']);
    $this->assertArrayHasKey('id', $jsonResponse['data'][0]);
    $this->assertArrayHasKey('name', $jsonResponse['data'][0]);
    $this->assertArrayHasKey('email', $jsonResponse['data'][0]);
    $this->assertArrayHasKey('roles', $jsonResponse['data'][0]);
    $this->assertArrayHasKey('permissions', $jsonResponse['data'][0]);
    $this->assertArrayHasKey('created_at', $jsonResponse['data'][0]);
    $this->assertArrayHasKey('updated_at', $jsonResponse['data'][0]);
});

it('can\'t paginate the user list.', function () {
    $user = User::factory()->create();
    $response = $this->withHeaders(authHeader($user))
        ->get('/users');
    $response->assertStatus(403);
});

it('finds by name partially.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.viewAny');

    $bob = User::factory()->create(['name' => 'Bob Marley']);
    User::factory()->create(['name' => 'Peter Tosh']);
    $response = $this->withHeaders(authHeader($user))
        ->get('/users?filter[name]=bob');
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                [
                    'id' => $bob->uuid,
                    'name' => $bob->name,
                    'email' => $bob->email,
                    'roles' => [],
                    'permissions' => [],
                    'created_at' => $bob->present()->createdAt,
                    'updated_at' => $bob->present()->updatedAt,
                ],
            ],
            'meta' => [
                'pagination' => [
                    'total' => 1,
                    'count' => 1,
                    'per_page' => 50,
                    'current_page' => 1,
                    'total_pages' => 1,
                    'links' => [],
                ],
            ],
        ]);
});

it('finds by email.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.viewAny');

    User::factory()->create(['email' => 'bob@test.com']);
    $peter = User::factory()->create(['email' => 'peter@test.com']);
    $response = $this->withHeaders(authHeader($user))
        ->get('/users?filter[email]=peter@test.com');
    $response->assertStatus(200)
        ->assertJson([
            'data' => [
                [
                    'id' => $peter->uuid,
                    'name' => $peter->name,
                    'email' => $peter->email,
                    'roles' => [],
                    'permissions' => [],
                    'created_at' => $peter->present()->createdAt,
                    'updated_at' => $peter->present()->updatedAt,
                ],
            ],
            'meta' => [
                'pagination' => [
                    'total' => 1,
                    'count' => 1,
                    'per_page' => 50,
                    'current_page' => 1,
                    'total_pages' => 1,
                    'links' => [],
                ],
            ],
        ]);
});

it('can\'t find by email partially.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('users.viewAny');

    User::factory()->create(['email' => 'bob@test.com']);
    User::factory()->create(['email' => 'peter@test.com']);
    $response = $this->withHeaders(authHeader($user))
        ->get('/users?filter[email]=bob');
    $response->assertStatus(200)
        ->assertJson([
            'data' => [],
            'meta' => [
                'pagination' => [
                    'total' => 0,
                    'count' => 0,
                    'per_page' => 50,
                    'current_page' => 1,
                    'total_pages' => 1,
                    'links' => [],
                ],
            ],
        ]);
});

it('sorts', function (string $sortString) {
    $user = User::factory()->create();
    $user->givePermissionTo('users.viewAny');

    User::factory()->count(5)->create();
    $response = $this->withHeaders(authHeader($user))
        ->get("/users?sort=$sortString");
    $response->assertStatus(200);
})->with('user-sorts');
