<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleveBalai extends Model
{
    use HasFactory;

    protected $table = 'maintenance_releves_balais';

    protected $fillable = [
        'maintenance_moteur_balai_position_id', 'user_id', 'date', 'compteur_heures',
        'longueur_mesuree_mm', 'etat_surface', 'liberte_coulissement', 'etat_tresse_cosse',
        'echauffement_coloration', 'pression_ressort', 'pression_unite', 'pression_conforme',
        'photo_avant_path', 'photo_apres_path', 'action_realisee', 'lot_monte', 'observation',
    ];

    protected $casts = [
        'date' => 'datetime',
        'longueur_mesuree_mm' => 'decimal:2',
        'liberte_coulissement' => 'boolean',
        'pression_ressort' => 'decimal:2',
        'pression_conforme' => 'boolean',
    ];

    public function position()
    {
        return $this->belongsTo(MoteurBalaiPosition::class, 'maintenance_moteur_balai_position_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function usureCumuleeMm(): float
    {
        return (float) $this->position->longueur_neuve_reference_mm - (float) $this->longueur_mesuree_mm;
    }

    public function pourcentageConsomme(): ?float
    {
        $utilisable = $this->position->longueurUtilisableMm();

        if ($utilisable === null || $utilisable <= 0) {
            return null;
        }

        return round($this->usureCumuleeMm() / $utilisable * 100, 1);
    }
}
