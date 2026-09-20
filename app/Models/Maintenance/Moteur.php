<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moteur extends Model
{
    use HasFactory;

    protected $table = 'maintenance_moteurs';

    protected $fillable = [
        'code_interne', 'qr_code', 'maintenance_emplacement_id', 'ligne', 'machine_entrainee',
        'repere_fonctionnel', 'statut',
        'constructeur', 'modele', 'numero_serie', 'annee', 'puissance_kw', 'tension_v', 'courant_a',
        'vitesse_tr_min', 'excitation', 'classe_isolation', 'indice_ip', 'service',
        'type_refroidissement', 'nombre_poles', 'roulements', 'collecteur',
        'nombre_porte_balais', 'nombre_balais_par_porte_balais',
        'classe_criticite', 'impact_securite', 'impact_production', 'impact_qualite',
        'redondance', 'delai_approvisionnement',
        'photo_plaque_path', 'photo_moteur_path',
        'seuil_isolement_mohm',
    ];

    protected $casts = [
        'collecteur' => 'boolean',
        'impact_securite' => 'boolean',
        'redondance' => 'boolean',
        'puissance_kw' => 'decimal:2',
        'tension_v' => 'decimal:2',
        'courant_a' => 'decimal:2',
        'seuil_isolement_mohm' => 'decimal:2',
    ];

    public const STATUT_LABELS = [
        'en_service' => 'En service',
        'en_reserve' => 'En réserve',
        'en_reparation' => 'En réparation',
        'indisponible' => 'Indisponible',
        'reforme' => 'Réformé',
    ];

    public const CRITICITE_LABELS = [
        'basse' => 'Basse',
        'moyenne' => 'Moyenne',
        'haute' => 'Haute',
        'vitale' => 'Vitale',
    ];

    public function emplacement()
    {
        return $this->belongsTo(Emplacement::class, 'maintenance_emplacement_id');
    }

    public function mesuresIsolement()
    {
        return $this->hasMany(MesureIsolement::class, 'maintenance_moteur_id')->orderByDesc('date');
    }

    public function balaiPositions()
    {
        return $this->hasMany(MoteurBalaiPosition::class, 'maintenance_moteur_id')->orderBy('ordre');
    }

    public function derniereMesureIsolement(): ?MesureIsolement
    {
        return $this->relationLoaded('mesuresIsolement')
            ? $this->mesuresIsolement->first()
            : $this->mesuresIsolement()->first();
    }

    /**
     * Déséquilibre entre le balai le plus long et le plus court, sur leur dernier relevé respectif.
     *
     * @return array{ecart_mm: ?float, tolerance_mm: ?float, hors_tolerance: bool}
     */
    public function desequilibreBalais(): array
    {
        $longueurs = $this->balaiPositions
            ->map(fn (MoteurBalaiPosition $position) => $position->dernierReleve()?->longueur_mesuree_mm)
            ->filter(fn ($valeur) => $valeur !== null)
            ->map(fn ($valeur) => (float) $valeur);

        if ($longueurs->count() < 2) {
            return ['ecart_mm' => null, 'tolerance_mm' => null, 'hors_tolerance' => false];
        }

        $ecart = round($longueurs->max() - $longueurs->min(), 2);

        $tolerance = $this->balaiPositions
            ->map(fn (MoteurBalaiPosition $position) => $position->balai?->tolerance_ecart_mm)
            ->filter(fn ($valeur) => $valeur !== null)
            ->map(fn ($valeur) => (float) $valeur)
            ->min();

        return [
            'ecart_mm' => $ecart,
            'tolerance_mm' => $tolerance,
            'hors_tolerance' => $tolerance !== null && $ecart > $tolerance,
        ];
    }
}
