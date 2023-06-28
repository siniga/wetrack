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
        'image',
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

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }
}
