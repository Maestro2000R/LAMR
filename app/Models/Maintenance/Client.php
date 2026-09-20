<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'maintenance_clients';

    protected $fillable = ['name', 'ice', 'phone', 'email'];

    public function sites()
    {
        return $this->hasMany(Site::class, 'maintenance_client_id');
    }
}
