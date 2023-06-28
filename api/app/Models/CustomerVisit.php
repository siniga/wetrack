<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerVisit extends Model
{
    use HasFactory;

    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('customer_visits.created_at', now()->month);
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
