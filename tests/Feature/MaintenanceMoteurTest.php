<?php

namespace Tests\Feature;

use App\Models\Maintenance\Client;
use App\Models\Maintenance\Emplacement;
use App\Models\Maintenance\Moteur;
use App\Models\Maintenance\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceMoteurTest extends TestCase
{
    use RefreshDatabase;

    private function emplacement(): Emplacement
    {
        $client = Client::create(['name' => 'Cimenterie Atlas']);
        $site = Site::create(['maintenance_client_id' => $client->id, 'name' => 'Usine Casablanca']);

        return Emplacement::create(['maintenance_site_id' => $site->id, 'name' => 'Broyeur cru']);
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/maintenance/moteurs')->assertRedirect('/login');
    }

    public function test_can_create_moteur(): void
    {
        $user = User::factory()->create();
        $emplacement = $this->emplacement();

        $response = $this->actingAs($user)->post('/maintenance/moteurs', [
            'code_interne' => 'MCC-100',
            'maintenance_emplacement_id' => $emplacement->id,
            'statut' => 'en_service',
            'classe_criticite' => 'haute',
        ]);

        $moteur = Moteur::where('code_interne', 'MCC-100')->first();
        $response->assertRedirect('/maintenance/moteurs/'.$moteur->id);
        $this->assertNotNull($moteur);
        $this->assertNotEmpty($moteur->qr_code);
    }

    public function test_code_interne_must_be_unique(): void
    {
        $user = User::factory()->create();
        $emplacement = $this->emplacement();

        Moteur::create([
            'code_interne' => 'MCC-200', 'qr_code' => 'QR-EXIST',
            'maintenance_emplacement_id' => $emplacement->id, 'statut' => 'en_service', 'classe_criticite' => 'moyenne',
        ]);

        $response = $this->actingAs($user)->post('/maintenance/moteurs', [
            'code_interne' => 'MCC-200',
            'maintenance_emplacement_id' => $emplacement->id,
            'statut' => 'en_service',
            'classe_criticite' => 'moyenne',
        ]);

        $response->assertSessionHasErrors('code_interne');
    }

    public function test_qr_code_endpoint_returns_svg(): void
    {
        $user = User::factory()->create();
        $emplacement = $this->emplacement();
        $moteur = Moteur::create([
            'code_interne' => 'MCC-300', 'qr_code' => 'QR-300',
            'maintenance_emplacement_id' => $emplacement->id, 'statut' => 'en_service', 'classe_criticite' => 'moyenne',
        ]);

        $response = $this->actingAs($user)->get("/maintenance/moteurs/{$moteur->id}/qr.svg");

        $response->assertOk();
        $response->assertHeader('Content-Type', 'image/svg+xml');
    }

    public function test_deleting_client_cascades_to_moteur(): void
    {
        $user = User::factory()->create();
        $emplacement = $this->emplacement();
        $moteur = Moteur::create([
            'code_interne' => 'MCC-400', 'qr_code' => 'QR-400',
            'maintenance_emplacement_id' => $emplacement->id, 'statut' => 'en_service', 'classe_criticite' => 'moyenne',
        ]);

        $client = $emplacement->site->client;
        $this->actingAs($user)->delete("/maintenance/clients/{$client->id}");

        $this->assertDatabaseMissing('maintenance_moteurs', ['id' => $moteur->id]);
    }
}
