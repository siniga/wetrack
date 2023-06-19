<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    public function getTotalQuantity() {
        return $this->order_products()->sum( 'quantity' );
    }

    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('created_at', now()->month);
    }

    public function customer() {
        return $this->belongsTo( Customer::class, 'customer_id' );
    }

    public function user() {
        return $this->belongsTo( User::class, 'user_id' );
    }
}
