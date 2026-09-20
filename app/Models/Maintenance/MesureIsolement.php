<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesureIsolement extends Model
{
    use HasFactory;

    protected $table = 'maintenance_mesures_isolement';

    protected $fillable = [
        'maintenance_moteur_id', 'maintenance_instrument_id', 'user_id',
        'date', 'etat_thermique', 'duree_arret_h', 'temperature_ambiante', 'temperature_enroulement',
        'humidite', 'nettoyage_prealable',
        'circuit', 'points_mesure', 'tension_essai_v', 'duree_essai_s', 'decharge_apres_essai', 'procedure_utilisee',
        'unite_saisie', 'r_30s_mohm', 'r_60s_mohm', 'r_10min_mohm', 'courant_fuite',
        'dar', 'pi', 'valeur_corrigee_mohm', 'seuil_applicable_mohm', 'decision', 'observation',
    ];

    protected $casts = [
        'date' => 'datetime',
        'nettoyage_prealable' => 'boolean',
        'decharge_apres_essai' => 'boolean',
        'r_30s_mohm' => 'decimal:3',
        'r_60s_mohm' => 'decimal:3',
        'r_10min_mohm' => 'decimal:3',
        'dar' => 'decimal:3',
        'pi' => 'decimal:3',
    ];

    public function moteur()
    {
        return $this->belongsTo(Moteur::class, 'maintenance_moteur_id');
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class, 'maintenance_instrument_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public const DECISION_LABELS = [
        'normal' => 'Normal',
        'a_surveiller' => 'À surveiller',
        'critique' => 'Critique',
        'non_interpretable' => 'Non interprétable',
    ];
}
