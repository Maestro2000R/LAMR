<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emplacement extends Model
{
    use HasFactory;

    protected $table = 'maintenance_emplacements';

    protected $fillable = ['maintenance_site_id', 'name', 'atelier'];

    public function site()
    {
        return $this->belongsTo(Site::class, 'maintenance_site_id');
    }

    public function moteurs()
    {
        return $this->hasMany(Moteur::class, 'maintenance_emplacement_id');
    }
}
