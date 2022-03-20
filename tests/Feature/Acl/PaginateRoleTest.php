<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('paginates the role list.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.viewAny');
    Role::factory()->count(5)->create();

    $response = $this->withToken(Auth::login($user))
        ->json('GET', '/roles?per_page=3&page=2')
        ->assertStatus(200);

    $jsonResponse = json_decode($response->getContent(), true);
    $this->assertArrayHasKey('data', $jsonResponse);
    $this->assertArrayHasKey('meta', $jsonResponse);
    $this->assertArrayHasKey('pagination', $jsonResponse['meta']);
    $this->assertEquals(5, $jsonResponse['meta']['pagination']['total']);
    $this->assertEquals(2, $jsonResponse['meta']['pagination']['count']);
    $this->assertCount(2, $jsonResponse['data']);
    $this->assertArrayHasKey('id', $jsonResponse['data'][0]);
    $this->assertArrayHasKey('name', $jsonResponse['data'][0]);
    $this->assertArrayHasKey('created_at', $jsonResponse['data'][0]);
    $this->assertArrayHasKey('updated_at', $jsonResponse['data'][0]);
});

it('can\'t paginate the role list.', function () {
    $user = User::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('GET', '/roles?per_page=3&page=2')
        ->assertStatus(403);
});

it('finds by name partially.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.viewAny');
    Role::factory()->create(['name' => 'Bob Marley & the Wailers']);
    Role::factory()->create();

    $response = $this->withToken(Auth::login($user))
        ->json('GET', '/roles?filter[name]=marley')
        ->assertStatus(200);
    $jsonResponse = json_decode($response->getContent(), true);
    $this->assertEquals(1, $jsonResponse['meta']['pagination']['total']);
    $this->assertEquals(1, $jsonResponse['meta']['pagination']['count']);
});

it('sorts', function (string $sortString) {
    $user = User::factory()
        ->create()
        ->givePermissionTo('roles.viewAny');
    Role::factory()->count(5)->create();

    $this->withToken(Auth::login($user))
        ->json('GET', "/roles?sort=$sortString")
        ->assertStatus(200);
})->with('permission-sorts');
