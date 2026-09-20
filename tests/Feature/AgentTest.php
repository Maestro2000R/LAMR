<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_agents(): void
    {
        $user = User::factory()->create();
        Agent::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/agents');

        $response->assertOk();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get('/agents');

        $response->assertRedirect('/login');
    }

    public function test_can_create_agent(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/agents', [
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.test',
            'phone' => '0600000000',
            'status' => 'active',
        ]);

        $response->assertRedirect('/agents');
        $this->assertDatabaseHas('agents', ['email' => 'jean.dupont@example.test']);
    }

    public function test_validation_fails_on_missing_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/agents', [
            'email' => 'sans-nom@example.test',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('agents', ['email' => 'sans-nom@example.test']);
    }

    public function test_can_update_agent(): void
    {
        $user = User::factory()->create();
        $agent = Agent::factory()->create(['name' => 'Ancien Nom']);

        $response = $this->actingAs($user)->put("/agents/{$agent->id}", [
            'name' => 'Nouveau Nom',
            'email' => $agent->email,
            'phone' => $agent->phone,
            'status' => $agent->status,
        ]);

        $response->assertRedirect('/agents');
        $this->assertDatabaseHas('agents', ['id' => $agent->id, 'name' => 'Nouveau Nom']);
    }

    public function test_can_delete_agent(): void
    {
        $user = User::factory()->create();
        $agent = Agent::factory()->create();

        $response = $this->actingAs($user)->delete("/agents/{$agent->id}");

        $response->assertRedirect('/agents');
        $this->assertDatabaseMissing('agents', ['id' => $agent->id]);
    }
}
