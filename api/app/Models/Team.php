<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;


    public function users()
    {
        return $this->belongsToMany(User::class, 'team_users');
    }
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
