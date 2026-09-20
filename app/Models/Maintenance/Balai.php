<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balai extends Model
{
    use HasFactory;

    protected $table = 'maintenance_balais';

    protected $fillable = [
        'reference', 'fabricant', 'nuance_grade', 'application',
        'longueur_neuve_mm', 'largeur_mm', 'epaisseur_mm',
        'longueur_min_mm', 'seuil_alerte_mm', 'tolerance_ecart_mm',
        'quantite_stock', 'seuil_reappro', 'fournisseur', 'delai_appro',
    ];

    protected $casts = [
        'longueur_neuve_mm' => 'decimal:2',
        'largeur_mm' => 'decimal:2',
        'epaisseur_mm' => 'decimal:2',
        'longueur_min_mm' => 'decimal:2',
        'seuil_alerte_mm' => 'decimal:2',
        'tolerance_ecart_mm' => 'decimal:2',
    ];

    public function longueurUtilisableMm(): ?float
    {
        if ($this->longueur_neuve_mm === null || $this->longueur_min_mm === null) {
            return null;
        }

        return (float) $this->longueur_neuve_mm - (float) $this->longueur_min_mm;
    }

    public function stockSousSeuil(): bool
    {
        return $this->seuil_reappro !== null && $this->quantite_stock <= $this->seuil_reappro;
    }
}
