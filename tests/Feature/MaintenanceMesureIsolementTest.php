<?php

namespace Tests\Feature;

use App\Models\Maintenance\Client;
use App\Models\Maintenance\Emplacement;
use App\Models\Maintenance\MesureIsolement;
use App\Models\Maintenance\Moteur;
use App\Models\Maintenance\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceMesureIsolementTest extends TestCase
{
    use RefreshDatabase;

    private function moteur(?float $seuil = 5): Moteur
    {
        $client = Client::create(['name' => 'Client Test']);
        $site = Site::create(['maintenance_client_id' => $client->id, 'name' => 'Site Test']);
        $emplacement = Emplacement::create(['maintenance_site_id' => $site->id, 'name' => 'Emplacement Test']);

        return Moteur::create([
            'code_interne' => 'MCC-'.uniqid(),
            'qr_code' => 'QR-'.uniqid(),
            'maintenance_emplacement_id' => $emplacement->id,
            'statut' => 'en_service',
            'classe_criticite' => 'moyenne',
            'seuil_isolement_mohm' => $seuil,
        ]);
    }

    public function test_can_record_mesure_with_computed_dar_pi_and_decision(): void
    {
        $user = User::factory()->create();
        $moteur = $this->moteur();

        $response = $this->actingAs($user)->post("/maintenance/moteurs/{$moteur->id}/mesures-isolement", [
            'date' => now()->format('Y-m-d\TH:i'),
            'etat_thermique' => 'froid',
            'circuit' => 'induit_masse',
            'tension_essai_v' => 500,
            'unite_saisie' => 'MOhm',
            'r_30s_mohm' => 100,
            'r_60s_mohm' => 140,
            'r_10min_mohm' => 210,
        ]);

        $response->assertRedirect("/maintenance/moteurs/{$moteur->id}");
        $mesure = MesureIsolement::first();
        $this->assertEquals(1.4, (float) $mesure->dar);
        $this->assertEquals(1.5, (float) $mesure->pi);
        $this->assertSame('normal', $mesure->decision);
    }

    public function test_readings_entered_in_giga_ohm_are_stored_in_mega_ohm(): void
    {
        $user = User::factory()->create();
        $moteur = $this->moteur();

        $this->actingAs($user)->post("/maintenance/moteurs/{$moteur->id}/mesures-isolement", [
            'date' => now()->format('Y-m-d\TH:i'),
            'etat_thermique' => 'froid',
            'circuit' => 'induit_masse',
            'tension_essai_v' => 500,
            'unite_saisie' => 'GOhm',
            'r_60s_mohm' => 2, // 2 GΩ
        ]);

        $mesure = MesureIsolement::first();
        $this->assertEquals(2000.0, (float) $mesure->r_60s_mohm);
    }

    public function test_negative_readings_are_rejected(): void
    {
        $user = User::factory()->create();
        $moteur = $this->moteur();

        $response = $this->actingAs($user)->post("/maintenance/moteurs/{$moteur->id}/mesures-isolement", [
            'date' => now()->format('Y-m-d\TH:i'),
            'etat_thermique' => 'froid',
            'circuit' => 'induit_masse',
            'tension_essai_v' => 500,
            'unite_saisie' => 'MOhm',
            'r_60s_mohm' => -5,
        ]);

        $response->assertSessionHasErrors('r_60s_mohm');
        $this->assertDatabaseCount('maintenance_mesures_isolement', 0);
    }

    public function test_deleting_moteur_cascades_to_mesures(): void
    {
        $user = User::factory()->create();
        $moteur = $this->moteur();

        MesureIsolement::create([
            'maintenance_moteur_id' => $moteur->id,
            'date' => now(),
            'etat_thermique' => 'froid',
            'circuit' => 'induit_masse',
            'tension_essai_v' => 500,
            'unite_saisie' => 'MOhm',
            'r_60s_mohm' => 50,
            'decision' => 'normal',
        ]);

        $this->actingAs($user)->delete("/maintenance/moteurs/{$moteur->id}");

        $this->assertDatabaseMissing('maintenance_mesures_isolement', ['maintenance_moteur_id' => $moteur->id]);
    }
}
