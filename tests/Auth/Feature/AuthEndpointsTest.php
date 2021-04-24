<?php

namespace Tests\Auth\Feature;

use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthEndpointsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_generates_the_jwt_token(): void
    {
        $user = User::factory()->create();
        $response = $this->json('POST', '/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Token generated.',
                'data' => [
                    'token_type' => 'Bearer',
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_gets_invalid_credentials(): void
    {
        $response = $this->json('POST', '/auth/login', [
            'email' => 'john.doe@example.com',
            'password' => $this->faker()->password,
        ]);
        $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials.',
            ])
        ;
    }

    /**
     * @test
     */
    public function it_cannot_login_without_email(): void
    {
        $response = $this->json('POST', '/auth/login', [
            'password' => $this->faker()->password,
        ]);
        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => [
                        'The email field is required.',
                    ],
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_cannot_login_without_invalid_email(): void
    {
        $response = $this->json('POST', '/auth/login', [
            'email' => $this->faker()->word,
            'password' => $this->faker()->password,
        ]);
        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => [
                        'The email must be a valid email address.',
                    ],
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_cannot_login_without_pass(): void
    {
        $response = $this->json('POST', '/auth/login', [
            'email' => $this->faker()->safeEmail,
        ]);
        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
            ])
        ;
    }

    /**
     * @test
     */
    public function it_log_off_successfuly(): void
    {
        $user = User::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('POST', '/auth/logout')
        ;
        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out.',
            ])
        ;
    }

    /**
     * @test
     */
    public function it_cannot_log_off(): void
    {
        $response = $this->json('POST', '/auth/logout');
        $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ])
        ;
    }

    /**
     * @test
     */
    public function it_refreshes_token(): void
    {
        $user = User::factory()->create();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('POST', '/auth/refresh')
        ;
        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Token generated.',
                'data' => [
                    'token_type' => 'Bearer',
                ],
            ])
        ;
    }

    /**
     * @test
     */
    public function it_cannot_refresh_token(): void
    {
        $response = $this->json('POST', '/auth/refresh');
        $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ])
        ;
    }
}
