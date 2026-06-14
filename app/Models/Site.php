<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'assignments')
            ->withPivot(['starts_at', 'ends_at', 'role'])
            ->withTimestamps();
    }
}
