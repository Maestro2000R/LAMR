<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'assignments')
            ->withPivot(['starts_at', 'ends_at', 'role'])
            ->withTimestamps();
    }
}
