<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cost',
        'price',
        'stock',
        'img',
        'sku',
        'business_id',
        'category_id',
    ];
    
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function businesses()
    {
        return $this->belongsTo(Business::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')
                    ->withPivot('total_quantity', 'total_amount');
    }
}
