<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('paginates the permission list.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('permissions.viewAny');

    $response = $this->withToken(Auth::login($user))
        ->json('GET', '/permissions')
        ->assertStatus(200);

    $jsonResponse = json_decode($response->getContent(), true);
    $this->assertArrayHasKey('data', $jsonResponse);
    $this->assertArrayHasKey('meta', $jsonResponse);
    $this->assertArrayHasKey('pagination', $jsonResponse['meta']);
    $this->assertEquals(11, $jsonResponse['meta']['pagination']['total']);
    $this->assertEquals(11, $jsonResponse['meta']['pagination']['count']);
    $this->assertCount(11, $jsonResponse['data']);
    $this->assertArrayHasKey('id', $jsonResponse['data'][0]);
    $this->assertArrayHasKey('name', $jsonResponse['data'][0]);
    $this->assertArrayHasKey('created_at', $jsonResponse['data'][0]);
    $this->assertArrayHasKey('updated_at', $jsonResponse['data'][0]);
});

it('can\'t paginate the permission list.', function () {
    $user = User::factory()->create();

    $this->withToken(Auth::login($user))
        ->json('GET', '/permissions')
        ->assertStatus(403);
});

it('finds by name partially.', function () {
    $user = User::factory()
        ->create()
        ->givePermissionTo('permissions.viewAny');

    $response = $this->withToken(Auth::login($user))
        ->json('GET', '/permissions?filter[name]=users')
        ->assertStatus(200);

    $jsonResponse = json_decode($response->getContent(), true);
    $this->assertEquals(5, $jsonResponse['meta']['pagination']['total']);
    $this->assertEquals(5, $jsonResponse['meta']['pagination']['count']);
});

it('sorts', function (string $sortString) {
    $user = User::factory()
        ->create()
        ->givePermissionTo('permissions.viewAny');

    $response = $this->withToken(Auth::login($user))
        ->json('GET', "/permissions?sort=$sortString");
    $response->assertStatus(200);
})->with('permission-sorts');
