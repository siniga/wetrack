<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    public function getTotalQuantity() {
        return $this->order_products()->sum( 'order_products.total_quantity' );
    }

    public function scopeCurrentMonth($query)
    {
        return $query->whereMonth('orders.created_at', now()->month);
    }

    public function customers() {
        return $this->belongsTo( Customer::class, 'customer_id' );
    }

    public function user() {
        return $this->belongsTo( User::class, 'user_id' );
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
                    ->withPivot('total_quantity', 'total_amount');
    }
}
