<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the district associated with the customer.
     */
    public function districts()
    {
        return $this->belongsTo(District::class,'district_id');
    }

    /**
     * Get the customer type associated with the customer.
     */
    public function customer_types()
    {
        return $this->belongsTo(CustomerType::class, 'customer_type_id');
    }

    public function customer_visits()
    {
        return $this->hasMany(CustomerVisit::class,'customer_id');
    }
}
