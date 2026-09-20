<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\Assignment;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_assignment_links_agent_and_site(): void
    {
        $agent = Agent::factory()->create();
        $site = Site::factory()->create();

        $assignment = Assignment::factory()->create([
            'agent_id' => $agent->id,
            'site_id' => $site->id,
        ]);

        $this->assertTrue($assignment->agent->is($agent));
        $this->assertTrue($assignment->site->is($site));
        $this->assertTrue($agent->assignments->contains($assignment));
    }

    public function test_deleting_agent_cascades_assignments(): void
    {
        $agent = Agent::factory()->create();
        $assignment = Assignment::factory()->create(['agent_id' => $agent->id]);

        $agent->delete();

        $this->assertDatabaseMissing('assignments', ['id' => $assignment->id]);
    }

    public function test_deleting_site_cascades_assignments(): void
    {
        $site = Site::factory()->create();
        $assignment = Assignment::factory()->create(['site_id' => $site->id]);

        $site->delete();

        $this->assertDatabaseMissing('assignments', ['id' => $assignment->id]);
    }

    public function test_can_create_assignment_via_web(): void
    {
        $user = User::factory()->create();
        $agent = Agent::factory()->create();
        $site = Site::factory()->create();

        $response = $this->actingAs($user)->post('/assignments', [
            'agent_id' => $agent->id,
            'site_id' => $site->id,
            'role' => 'Surveillance',
            'starts_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $response->assertRedirect('/assignments');
        $this->assertDatabaseHas('assignments', [
            'agent_id' => $agent->id,
            'site_id' => $site->id,
            'role' => 'Surveillance',
        ]);
    }

    public function test_validation_fails_when_end_before_start(): void
    {
        $user = User::factory()->create();
        $agent = Agent::factory()->create();
        $site = Site::factory()->create();

        $response = $this->actingAs($user)->post('/assignments', [
            'agent_id' => $agent->id,
            'site_id' => $site->id,
            'starts_at' => now()->format('Y-m-d H:i:s'),
            'ends_at' => now()->subDay()->format('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors('ends_at');
    }
}
