<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $table = 'maintenance_instruments';

    protected $fillable = ['type', 'marque', 'modele', 'numero_serie', 'date_etalonnage', 'date_expiration'];

    protected $casts = [
        'date_etalonnage' => 'date',
        'date_expiration' => 'date',
    ];

    public function mesuresIsolement()
    {
        return $this->hasMany(MesureIsolement::class, 'maintenance_instrument_id');
    }

    public function estValide(): bool
    {
        return $this->date_expiration === null || $this->date_expiration->isFuture();
    }
}
