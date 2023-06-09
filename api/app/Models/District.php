<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    public function customers()
    {
        return $this->hasMany(Customer::class,'district_id');
    }

    public function regions()
    {
        return $this->belongsTo(Region::class);
    }
}

