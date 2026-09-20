<?php

namespace Database\Seeders;

use App\Models\Maintenance\Balai;
use App\Models\Maintenance\Client;
use App\Models\Maintenance\Emplacement;
use App\Models\Maintenance\Instrument;
use App\Models\Maintenance\MesureIsolement;
use App\Models\Maintenance\Moteur;
use App\Models\Maintenance\MoteurBalaiPosition;
use App\Models\Maintenance\ReleveBalai;
use App\Models\Maintenance\Site;
use App\Models\User;
use App\Services\Maintenance\IsolationAnalyzer;
use Illuminate\Database\Seeder;

class MaintenanceDemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $analyzer = new IsolationAnalyzer();

        $atlas = Client::create(['name' => 'Cimenterie Atlas', 'ice' => '001122334400015', 'phone' => '0522000000', 'email' => 'contact@atlas-ciment.test']);
        $sud = Client::create(['name' => 'Minoterie du Sud', 'ice' => '001122334400099', 'phone' => '0528000000', 'email' => 'contact@minoterie-sud.test']);

        $siteAtlas = Site::create(['maintenance_client_id' => $atlas->id, 'name' => 'Usine Casablanca', 'address' => 'Zone Industrielle Ain Sebaa', 'city' => 'Casablanca']);
        $siteSud = Site::create(['maintenance_client_id' => $sud->id, 'name' => 'Unité Agadir', 'address' => 'Route de Aït Melloul', 'city' => 'Agadir']);

        $empBroyeur = Emplacement::create(['maintenance_site_id' => $siteAtlas->id, 'name' => 'Broyeur cru', 'atelier' => 'Atelier cuisson']);
        $empConvoyeur = Emplacement::create(['maintenance_site_id' => $siteAtlas->id, 'name' => 'Convoyeur clinker', 'atelier' => 'Atelier manutention']);
        $empMoulin = Emplacement::create(['maintenance_site_id' => $siteSud->id, 'name' => 'Moulin à farine', 'atelier' => 'Atelier mouture']);

        $instrumentOk = Instrument::create([
            'type' => 'megohmmetre', 'marque' => 'Megger', 'modele' => 'MIT525',
            'numero_serie' => 'MEG-2024-018', 'date_etalonnage' => now()->subMonths(4), 'date_expiration' => now()->addMonths(8),
        ]);
        $instrumentPerime = Instrument::create([
            'type' => 'megohmmetre', 'marque' => 'Fluke', 'modele' => '1587FC',
            'numero_serie' => 'FLK-2022-004', 'date_etalonnage' => now()->subMonths(20), 'date_expiration' => now()->subMonths(2),
        ]);

        $balaiA = Balai::create([
            'reference' => 'MG-64-EG', 'fabricant' => 'Mersen', 'nuance_grade' => 'EG68', 'application' => 'Moteurs CC industriels',
            'longueur_neuve_mm' => 40, 'largeur_mm' => 16, 'epaisseur_mm' => 8,
            'longueur_min_mm' => 20, 'seuil_alerte_mm' => 24, 'tolerance_ecart_mm' => 3,
            'quantite_stock' => 18, 'seuil_reappro' => 8, 'fournisseur' => 'Mersen Maroc', 'delai_appro' => '2 semaines',
        ]);
        $balaiB = Balai::create([
            'reference' => 'SK-51-CG', 'fabricant' => 'Schunk', 'nuance_grade' => 'CG613', 'application' => 'Moteurs CC forte puissance',
            'longueur_neuve_mm' => 50, 'largeur_mm' => 20, 'epaisseur_mm' => 10,
            'longueur_min_mm' => 25, 'seuil_alerte_mm' => 30, 'tolerance_ecart_mm' => 3,
            'quantite_stock' => 4, 'seuil_reappro' => 6, 'fournisseur' => 'Schunk France', 'delai_appro' => '4 semaines',
        ]);

        $moteur1 = Moteur::create([
            'code_interne' => 'MCC-001', 'qr_code' => 'MCC001QR', 'maintenance_emplacement_id' => $empBroyeur->id,
            'ligne' => 'Ligne 1', 'machine_entrainee' => 'Broyeur cru B1', 'repere_fonctionnel' => '10-BC-001', 'statut' => 'en_service',
            'constructeur' => 'Leroy-Somer', 'modele' => 'LSK 400', 'numero_serie' => 'LS-778452', 'annee' => 2016,
            'puissance_kw' => 250, 'tension_v' => 440, 'courant_a' => 610, 'vitesse_tr_min' => 750, 'excitation' => 'Shunt',
            'classe_isolation' => 'F', 'indice_ip' => 'IP23', 'service' => 'S1',
            'type_refroidissement' => 'IC06', 'nombre_poles' => 8, 'roulements' => 'À rouleaux', 'collecteur' => true,
            'nombre_porte_balais' => 4, 'nombre_balais_par_porte_balais' => 2,
            'classe_criticite' => 'vitale', 'impact_securite' => true, 'impact_production' => 'Arrêt total de la ligne cuisson',
            'redondance' => false, 'delai_approvisionnement' => '6 semaines',
            'seuil_isolement_mohm' => 5,
        ]);

        $moteur2 = Moteur::create([
            'code_interne' => 'MCC-002', 'qr_code' => 'MCC002QR', 'maintenance_emplacement_id' => $empConvoyeur->id,
            'ligne' => 'Ligne 1', 'machine_entrainee' => 'Convoyeur à bande CV-12', 'repere_fonctionnel' => '20-CV-012', 'statut' => 'en_service',
            'constructeur' => 'ABB', 'modele' => 'DMI 180', 'numero_serie' => 'ABB-334219', 'annee' => 2019,
            'puissance_kw' => 55, 'tension_v' => 400, 'courant_a' => 150, 'vitesse_tr_min' => 1150, 'excitation' => 'Série',
            'classe_isolation' => 'H', 'indice_ip' => 'IP44', 'service' => 'S1',
            'type_refroidissement' => 'IC17', 'nombre_poles' => 4, 'roulements' => 'À billes', 'collecteur' => true,
            'nombre_porte_balais' => 4, 'nombre_balais_par_porte_balais' => 1,
            'classe_criticite' => 'haute', 'impact_securite' => false, 'impact_production' => 'Ralentissement manutention clinker',
            'redondance' => true, 'delai_approvisionnement' => '3 semaines',
            'seuil_isolement_mohm' => 2,
        ]);

        Moteur::create([
            'code_interne' => 'MCC-010', 'qr_code' => 'MCC010QR', 'maintenance_emplacement_id' => $empMoulin->id,
            'ligne' => null, 'machine_entrainee' => 'Moulin à cylindres M3', 'repere_fonctionnel' => 'M3-MOT', 'statut' => 'en_reparation',
            'constructeur' => 'Siemens', 'modele' => '1GG5', 'numero_serie' => 'SIE-902341', 'annee' => 2012,
            'puissance_kw' => 30, 'tension_v' => 220, 'courant_a' => 140, 'vitesse_tr_min' => 1450, 'excitation' => 'Shunt',
            'classe_isolation' => 'F', 'indice_ip' => 'IP54', 'service' => 'S1',
            'type_refroidissement' => 'IC06', 'nombre_poles' => 4, 'roulements' => 'À billes', 'collecteur' => true,
            'nombre_porte_balais' => 2, 'nombre_balais_par_porte_balais' => 1,
            'classe_criticite' => 'moyenne', 'impact_securite' => false, 'impact_production' => 'Arrêt mouture ligne 3',
            'redondance' => false, 'delai_approvisionnement' => '5 semaines',
            'seuil_isolement_mohm' => 1,
        ]);

        // Historique de mesures d'isolement sur le moteur 1 : tendance à la baisse jusqu'à devenir critique.
        $historique1 = [
            ['date' => now()->subMonths(6), 'r30' => 180, 'r60' => 260, 'r10' => 410],
            ['date' => now()->subMonths(4), 'r30' => 140, 'r60' => 195, 'r10' => 290],
            ['date' => now()->subMonths(2), 'r30' => 60, 'r60' => 78, 'r10' => 105],
            ['date' => now()->subDays(10), 'r30' => 12, 'r60' => 14, 'r10' => 17],
        ];
        foreach ($historique1 as $point) {
            $data = [
                'maintenance_instrument_id' => $instrumentOk->id,
                'date' => $point['date'],
                'etat_thermique' => 'froid',
                'temperature_ambiante' => 24,
                'nettoyage_prealable' => true,
                'circuit' => 'induit_masse',
                'tension_essai_v' => 500,
                'duree_essai_s' => 600,
                'decharge_apres_essai' => true,
                'unite_saisie' => 'MOhm',
                'r_30s_mohm' => $point['r30'],
                'r_60s_mohm' => $point['r60'],
                'r_10min_mohm' => $point['r10'],
            ];
            $analyse = $analyzer->analyser($data + ['seuil_applicable_mohm' => $moteur1->seuil_isolement_mohm], $moteur1);
            MesureIsolement::create($data + [
                'maintenance_moteur_id' => $moteur1->id,
                'user_id' => $user?->id,
                'seuil_applicable_mohm' => $moteur1->seuil_isolement_mohm,
                'dar' => $analyse['dar'],
                'pi' => $analyse['pi'],
                'decision' => $analyse['decision'],
            ]);
        }

        // Une mesure normale et récente sur le moteur 2, avec instrument périmé pour illustrer l'alerte.
        $data2 = [
            'maintenance_instrument_id' => $instrumentPerime->id,
            'date' => now()->subDays(3),
            'etat_thermique' => 'froid',
            'temperature_ambiante' => 22,
            'nettoyage_prealable' => false,
            'circuit' => 'induit_masse',
            'tension_essai_v' => 500,
            'duree_essai_s' => 60,
            'decharge_apres_essai' => true,
            'unite_saisie' => 'MOhm',
            'r_30s_mohm' => 320,
            'r_60s_mohm' => 410,
            'r_10min_mohm' => null,
        ];
        $analyse2 = $analyzer->analyser($data2 + ['seuil_applicable_mohm' => $moteur2->seuil_isolement_mohm], $moteur2);
        MesureIsolement::create($data2 + [
            'maintenance_moteur_id' => $moteur2->id,
            'user_id' => $user?->id,
            'seuil_applicable_mohm' => $moteur2->seuil_isolement_mohm,
            'dar' => $analyse2['dar'],
            'pi' => $analyse2['pi'],
            'decision' => $analyse2['decision'],
        ]);

        // Positions de balais + relevés chronologiques sur le moteur 1 (montre usure/vitesse/autonomie/déséquilibre).
        $positions = [];
        foreach (['Avant-Droit', 'Avant-Gauche', 'Arrière-Droit', 'Arrière-Gauche'] as $i => $label) {
            $positions[] = MoteurBalaiPosition::create([
                'maintenance_moteur_id' => $moteur1->id,
                'maintenance_balai_id' => $balaiA->id,
                'position' => $label,
                'porte_balais' => 'PB-'.($i + 1),
                'longueur_neuve_reference_mm' => 40,
                'ordre' => $i,
            ]);
        }

        $releveHistorique = [
            ['date' => now()->subMonths(5), 'heures' => 1000, 'longueurs' => [37, 37.2, 36.8, 37]],
            ['date' => now()->subMonths(3), 'heures' => 2500, 'longueurs' => [32, 32.5, 31.5, 32]],
            ['date' => now()->subDays(15), 'heures' => 3600, 'longueurs' => [26, 27, 24.5, 26.5]],
        ];
        foreach ($releveHistorique as $point) {
            foreach ($positions as $index => $position) {
                ReleveBalai::create([
                    'maintenance_moteur_balai_position_id' => $position->id,
                    'user_id' => $user?->id,
                    'date' => $point['date'],
                    'compteur_heures' => $point['heures'],
                    'longueur_mesuree_mm' => $point['longueurs'][$index],
                    'etat_surface' => 'normal',
                    'liberte_coulissement' => true,
                    'action_realisee' => 'aucune',
                ]);
            }
        }

        // Une position sur le moteur 2, sans historique, pour illustrer un cas "aucun relevé".
        MoteurBalaiPosition::create([
            'maintenance_moteur_id' => $moteur2->id,
            'maintenance_balai_id' => $balaiB->id,
            'position' => 'Unique',
            'longueur_neuve_reference_mm' => 50,
            'ordre' => 0,
        ]);
    }
}
