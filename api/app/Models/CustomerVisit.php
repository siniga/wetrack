<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerVisit extends Model
{
    use HasFactory;

    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('created_at', now()->month);
    }
}