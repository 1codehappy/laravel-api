<?php

namespace Tests\Permission\Feature;

use App\Domain\Permission\Models\Permission;
use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PermissionEndpointsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_list_permissions()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('permissions.read')
        ;
        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('GET', '/permissions?per_page=5')
        ;
        $response
            ->assertHeader('Content-Type', 'application/json')
            ->assertStatus(200)
        ;
        $jsonResponse = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $jsonResponse);
        $this->assertArrayHasKey('meta', $jsonResponse);
        $this->assertArrayHasKey('pagination', $jsonResponse['meta']);
        $this->assertEquals(Permission::count(), $jsonResponse['meta']['pagination']['total']);
        $this->assertEquals(5, $jsonResponse['meta']['pagination']['count']);
        $this->assertCount(5, $jsonResponse['data']);
        $this->assertArrayHasKey('id', $jsonResponse['data'][0]);
        $this->assertArrayHasKey('name', $jsonResponse['data'][0]);
    }

    /**
     * @test
     */
    public function it_can_find_permissions_by_name()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('permissions.read')
        ;
        Permission::factory()->create([
            'name' => 'Ola Mundo',
        ]);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . Auth::login($user),
        ])->json('GET', '/permissions' . '?filter[name]=ola m');
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
    public function it_can_sort_permissions_by()
    {
        $user = User::factory()
            ->create()
            ->givePermissionTo('permissions.read')
        ;
        $orientation = ['', '-'];
        foreach ($orientation as $concat) {
            $response = $this->withHeaders([
                    'Authorization' => 'Bearer ' . Auth::login($user),
                ])
                ->json('GET', "/permissions?sort={$concat}name")
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
    public function it_validates_permission_for_listing_permissions()
    {
        $user = User::factory()->create();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . Auth::login($user),
            ])
            ->json('GET', '/permissions')
        ;
        $response->assertStatus(403);
    }
}
