<?php

namespace Tests\Unit;

use App\Models\Maintenance\Client;
use App\Models\Maintenance\Emplacement;
use App\Models\Maintenance\MesureIsolement;
use App\Models\Maintenance\Moteur;
use App\Models\Maintenance\Site;
use App\Services\Maintenance\IsolationAnalyzer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IsolationAnalyzerTest extends TestCase
{
    use RefreshDatabase;

    private function moteur(?float $seuil = 5): Moteur
    {
        $client = Client::create(['name' => 'Client Test']);
        $site = Site::create(['maintenance_client_id' => $client->id, 'name' => 'Site Test']);
        $emplacement = Emplacement::create(['maintenance_site_id' => $site->id, 'name' => 'Emplacement Test']);

        return Moteur::create([
            'code_interne' => 'MCC-TEST-'.uniqid(),
            'qr_code' => 'QR-'.uniqid(),
            'maintenance_emplacement_id' => $emplacement->id,
            'statut' => 'en_service',
            'classe_criticite' => 'moyenne',
            'seuil_isolement_mohm' => $seuil,
        ]);
    }

    public function test_dar_and_pi_are_computed_when_readings_present(): void
    {
        $analyzer = new IsolationAnalyzer();
        $moteur = $this->moteur();

        $result = $analyzer->analyser([
            'r_30s_mohm' => 100,
            'r_60s_mohm' => 140,
            'r_10min_mohm' => 210,
        ], $moteur);

        $this->assertEquals(1.4, $result['dar']);
        $this->assertEquals(1.5, $result['pi']);
    }

    public function test_dar_and_pi_are_null_when_readings_missing(): void
    {
        $analyzer = new IsolationAnalyzer();
        $moteur = $this->moteur();

        $result = $analyzer->analyser(['r_30s_mohm' => 100], $moteur);

        $this->assertNull($result['dar']);
        $this->assertNull($result['pi']);
    }

    public function test_classified_non_interpretable_without_threshold(): void
    {
        $analyzer = new IsolationAnalyzer();
        $moteur = $this->moteur(seuil: null);

        $result = $analyzer->analyser(['r_60s_mohm' => 100], $moteur);

        $this->assertSame('non_interpretable', $result['decision']);
    }

    public function test_classified_critique_below_threshold(): void
    {
        $analyzer = new IsolationAnalyzer();
        $moteur = $this->moteur(seuil: 5);

        $result = $analyzer->analyser(['r_60s_mohm' => 3, 'circuit' => 'induit_masse', 'etat_thermique' => 'froid'], $moteur);

        $this->assertSame('critique', $result['decision']);
    }

    public function test_classified_normal_when_well_above_threshold_and_stable(): void
    {
        $analyzer = new IsolationAnalyzer();
        $moteur = $this->moteur(seuil: 5);

        $result = $analyzer->analyser(['r_60s_mohm' => 100, 'circuit' => 'induit_masse', 'etat_thermique' => 'froid'], $moteur);

        $this->assertSame('normal', $result['decision']);
    }

    public function test_classified_a_surveiller_on_significant_drop(): void
    {
        $analyzer = new IsolationAnalyzer();
        $moteur = $this->moteur(seuil: 5);

        MesureIsolement::create([
            'maintenance_moteur_id' => $moteur->id,
            'date' => now()->subMonth(),
            'etat_thermique' => 'froid',
            'circuit' => 'induit_masse',
            'tension_essai_v' => 500,
            'unite_saisie' => 'MOhm',
            'r_60s_mohm' => 100,
            'decision' => 'normal',
        ]);

        // Chute de 25% par rapport à la mesure précédente comparable (même circuit, même état thermique).
        $result = $analyzer->analyser([
            'r_60s_mohm' => 75,
            'circuit' => 'induit_masse',
            'etat_thermique' => 'froid',
        ], $moteur);

        $this->assertSame('a_surveiller', $result['decision']);
        $this->assertEquals(-25.0, $result['tendance_pourcentage']);
    }

    public function test_classified_critique_on_severe_drop_even_above_threshold(): void
    {
        $analyzer = new IsolationAnalyzer();
        $moteur = $this->moteur(seuil: 5);

        MesureIsolement::create([
            'maintenance_moteur_id' => $moteur->id,
            'date' => now()->subMonth(),
            'etat_thermique' => 'froid',
            'circuit' => 'induit_masse',
            'tension_essai_v' => 500,
            'unite_saisie' => 'MOhm',
            'r_60s_mohm' => 200,
            'decision' => 'normal',
        ]);

        // Chute de 60%, mais toujours largement au-dessus du seuil : la tendance doit tout de même déclencher "critique".
        $result = $analyzer->analyser([
            'r_60s_mohm' => 80,
            'circuit' => 'induit_masse',
            'etat_thermique' => 'froid',
        ], $moteur);

        $this->assertSame('critique', $result['decision']);
    }

    public function test_does_not_compare_measurements_on_different_circuits(): void
    {
        $analyzer = new IsolationAnalyzer();
        $moteur = $this->moteur(seuil: 5);

        MesureIsolement::create([
            'maintenance_moteur_id' => $moteur->id,
            'date' => now()->subMonth(),
            'etat_thermique' => 'froid',
            'circuit' => 'excitation_shunt_masse',
            'tension_essai_v' => 500,
            'unite_saisie' => 'MOhm',
            'r_60s_mohm' => 500,
            'decision' => 'normal',
        ]);

        $result = $analyzer->analyser([
            'r_60s_mohm' => 100,
            'circuit' => 'induit_masse',
            'etat_thermique' => 'froid',
        ], $moteur);

        $this->assertNull($result['tendance_pourcentage']);
        $this->assertSame('normal', $result['decision']);
    }
}
