<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAgentTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_request_is_rejected(): void
    {
        $response = $this->postJson('/api/agents', []);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_list_agents_as_json(): void
    {
        $user = User::factory()->create();
        Agent::factory()->count(3)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/agents');

        $response->assertOk();
        $response->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_can_obtain_a_token_with_valid_credentials(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->postJson('/api/tokens', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'phpunit',
        ]);

        $response->assertOk();
        $response->assertJsonStructure(['token']);
    }
}
