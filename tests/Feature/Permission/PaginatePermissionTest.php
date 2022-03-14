<?php

use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('paginates the permission list.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('permissions.viewAny');

    $response = $this->withHeaders(authHeader($user))
        ->get('/permissions');
    $response->assertStatus(200);
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
    $response = $this->withHeaders(authHeader($user))
        ->get('/permissions');
    $response->assertStatus(403);
});

it('finds by name partially.', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('permissions.viewAny');

    $response = $this->withHeaders(authHeader($user))
        ->get('/permissions?filter[name]=users');
    $response->assertStatus(200);
    $jsonResponse = json_decode($response->getContent(), true);
    $this->assertEquals(5, $jsonResponse['meta']['pagination']['total']);
    $this->assertEquals(5, $jsonResponse['meta']['pagination']['count']);
});

it('sorts', function (string $sortString) {
    $user = User::factory()->create();
    $user->givePermissionTo('permissions.viewAny');

    User::factory()->count(5)->create();
    $response = $this->withHeaders(authHeader($user))
        ->get("/permissions?sort=$sortString");
    $response->assertStatus(200);
})->with('permission-sorts');
