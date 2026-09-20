<?php

namespace Tests\Unit;

use App\Models\Maintenance\Balai;
use App\Models\Maintenance\Client;
use App\Models\Maintenance\Emplacement;
use App\Models\Maintenance\Moteur;
use App\Models\Maintenance\MoteurBalaiPosition;
use App\Models\Maintenance\ReleveBalai;
use App\Models\Maintenance\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MoteurBalaiPositionTest extends TestCase
{
    use RefreshDatabase;

    private function position(): MoteurBalaiPosition
    {
        $client = Client::create(['name' => 'Client Test']);
        $site = Site::create(['maintenance_client_id' => $client->id, 'name' => 'Site Test']);
        $emplacement = Emplacement::create(['maintenance_site_id' => $site->id, 'name' => 'Emplacement Test']);
        $moteur = Moteur::create([
            'code_interne' => 'MCC-'.uniqid(),
            'qr_code' => 'QR-'.uniqid(),
            'maintenance_emplacement_id' => $emplacement->id,
            'statut' => 'en_service',
            'classe_criticite' => 'moyenne',
        ]);
        $balai = Balai::create([
            'reference' => 'REF-'.uniqid(),
            'longueur_neuve_mm' => 40,
            'longueur_min_mm' => 20,
            'tolerance_ecart_mm' => 3,
            'quantite_stock' => 10,
        ]);

        return MoteurBalaiPosition::create([
            'maintenance_moteur_id' => $moteur->id,
            'maintenance_balai_id' => $balai->id,
            'position' => 'Avant',
            'longueur_neuve_reference_mm' => 40,
        ]);
    }

    public function test_usure_cumulee_and_pourcentage(): void
    {
        $position = $this->position();
        $releve = ReleveBalai::create([
            'maintenance_moteur_balai_position_id' => $position->id,
            'date' => now(),
            'longueur_mesuree_mm' => 30,
            'etat_surface' => 'normal',
            'action_realisee' => 'aucune',
        ]);

        // usure = 40 - 30 = 10mm ; utilisable = 40 - 20 = 20mm => 50%
        $this->assertEquals(10.0, $releve->usureCumuleeMm());
        $this->assertEquals(50.0, $releve->pourcentageConsomme());
    }

    public function test_vitesse_usure_requires_two_comparable_releves(): void
    {
        $position = $this->position();

        ReleveBalai::create([
            'maintenance_moteur_balai_position_id' => $position->id,
            'date' => now()->subDays(30),
            'compteur_heures' => 1000,
            'longueur_mesuree_mm' => 35,
            'etat_surface' => 'normal',
            'action_realisee' => 'aucune',
        ]);

        $this->assertNull($position->vitesseUsureMmParHeure());

        ReleveBalai::create([
            'maintenance_moteur_balai_position_id' => $position->id,
            'date' => now(),
            'compteur_heures' => 1500,
            'longueur_mesuree_mm' => 30,
            'etat_surface' => 'normal',
            'action_realisee' => 'aucune',
        ]);

        // (35 - 30) mm / (1500 - 1000) h = 0.01 mm/h
        $this->assertEquals(0.01, $position->vitesseUsureMmParHeure());
    }

    public function test_autonomie_estimee_uses_wear_rate_and_remaining_length(): void
    {
        $position = $this->position();

        ReleveBalai::create([
            'maintenance_moteur_balai_position_id' => $position->id,
            'date' => now()->subDays(30),
            'compteur_heures' => 1000,
            'longueur_mesuree_mm' => 35,
            'etat_surface' => 'normal',
            'action_realisee' => 'aucune',
        ]);
        ReleveBalai::create([
            'maintenance_moteur_balai_position_id' => $position->id,
            'date' => now(),
            'compteur_heures' => 1500,
            'longueur_mesuree_mm' => 30,
            'etat_surface' => 'normal',
            'action_realisee' => 'aucune',
        ]);

        // longueur restante = 30 - 20 = 10mm ; vitesse = 0.01 mm/h => 1000h, "indicative" (moins de 3 relevés)
        $autonomie = $position->autonomieEstimee();
        $this->assertEquals(1000.0, $autonomie['heures']);
        $this->assertSame('indicative', $autonomie['fiabilite']);
    }

    public function test_desequilibre_entre_positions(): void
    {
        $position1 = $this->position();
        $moteur = $position1->moteur;
        $balai = $position1->balai;

        $position2 = MoteurBalaiPosition::create([
            'maintenance_moteur_id' => $moteur->id,
            'maintenance_balai_id' => $balai->id,
            'position' => 'Arrière',
            'longueur_neuve_reference_mm' => 40,
        ]);

        ReleveBalai::create([
            'maintenance_moteur_balai_position_id' => $position1->id,
            'date' => now(),
            'longueur_mesuree_mm' => 30,
            'etat_surface' => 'normal',
            'action_realisee' => 'aucune',
        ]);
        ReleveBalai::create([
            'maintenance_moteur_balai_position_id' => $position2->id,
            'date' => now(),
            'longueur_mesuree_mm' => 25,
            'etat_surface' => 'normal',
            'action_realisee' => 'aucune',
        ]);

        $moteur->load('balaiPositions.releves', 'balaiPositions.balai');
        $desequilibre = $moteur->desequilibreBalais();

        $this->assertEquals(5.0, $desequilibre['ecart_mm']);
        $this->assertEquals(3.0, $desequilibre['tolerance_mm']);
        $this->assertTrue($desequilibre['hors_tolerance']);
    }
}
