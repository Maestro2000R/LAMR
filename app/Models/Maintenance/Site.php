<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $table = 'maintenance_sites';

    protected $fillable = ['maintenance_client_id', 'name', 'address', 'city'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'maintenance_client_id');
    }

    public function emplacements()
    {
        return $this->hasMany(Emplacement::class, 'maintenance_site_id');
    }
}
