<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'site_id',
        'starts_at',
        'ends_at',
        'role',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
