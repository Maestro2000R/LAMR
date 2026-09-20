<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoteurBalaiPosition extends Model
{
    use HasFactory;

    protected $table = 'maintenance_moteur_balai_positions';

    protected $fillable = [
        'maintenance_moteur_id', 'maintenance_balai_id', 'position',
        'porte_balais', 'longueur_neuve_reference_mm', 'ordre',
    ];

    protected $casts = [
        'longueur_neuve_reference_mm' => 'decimal:2',
    ];

    public function moteur()
    {
        return $this->belongsTo(Moteur::class, 'maintenance_moteur_id');
    }

    public function balai()
    {
        return $this->belongsTo(Balai::class, 'maintenance_balai_id');
    }

    public function releves()
    {
        return $this->hasMany(ReleveBalai::class, 'maintenance_moteur_balai_position_id')->orderByDesc('date');
    }

    public function dernierReleve(): ?ReleveBalai
    {
        return $this->relationLoaded('releves')
            ? $this->releves->first()
            : $this->releves()->first();
    }

    public function longueurMinMm(): ?float
    {
        return $this->balai?->longueur_min_mm !== null ? (float) $this->balai->longueur_min_mm : null;
    }

    public function longueurUtilisableMm(): ?float
    {
        $min = $this->longueurMinMm();

        return $min === null ? null : (float) $this->longueur_neuve_reference_mm - $min;
    }

    /**
     * Vitesse d'usure (mm/heure) entre les deux derniers relevés comparables.
     * Retourne null si moins de deux relevés valides existent.
     */
    public function vitesseUsureMmParHeure(): ?float
    {
        $releves = $this->releves()->whereNotNull('compteur_heures')->orderByDesc('date')->limit(2)->get();

        if ($releves->count() < 2) {
            return null;
        }

        [$recent, $precedent] = $releves->all();

        $deltaLongueur = (float) $precedent->longueur_mesuree_mm - (float) $recent->longueur_mesuree_mm;
        $deltaHeures = $recent->compteur_heures - $precedent->compteur_heures;

        if ($deltaHeures <= 0) {
            return null;
        }

        return $deltaLongueur / $deltaHeures;
    }

    /**
     * Autonomie estimée en heures avant d'atteindre la limite, avec sa fiabilité.
     *
     * @return array{heures: ?float, fiabilite: string}
     */
    public function autonomieEstimee(): array
    {
        $vitesse = $this->vitesseUsureMmParHeure();
        $dernier = $this->dernierReleve();
        $min = $this->longueurMinMm();

        if ($vitesse === null || $vitesse <= 0 || $dernier === null || $min === null) {
            return ['heures' => null, 'fiabilite' => 'indisponible'];
        }

        $longueurRestante = (float) $dernier->longueur_mesuree_mm - $min;
        $nombreReleves = $this->releves()->whereNotNull('compteur_heures')->count();

        return [
            'heures' => max(0, $longueurRestante / $vitesse),
            'fiabilite' => $nombreReleves >= 3 ? 'fiable' : 'indicative',
        ];
    }
}
