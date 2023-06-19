<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model {
    protected $table = 'order_products';

    use HasFactory;

    public  function getTotalAmount() {

        $totalAmount = OrderProduct::sum( 'price' );
        return $totalAmount;
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
