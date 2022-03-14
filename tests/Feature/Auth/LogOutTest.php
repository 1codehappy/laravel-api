<?php

use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('was logged out successfully.', function () {
    $user = User::factory()->create();

    $response = $this->withHeaders(authHeader($user))
        ->post('/auth/logout');
    $response->assertStatus(200)
        ->assertJson([ 'message' => 'You\'re logged out successfully.' ]);
});

it('can\'t log out.', function () {
    $response = $this->post('/auth/logout');
    $response->assertStatus(401)
        ->assertJson([ 'message' => 'Unauthenticated.' ]);
});
