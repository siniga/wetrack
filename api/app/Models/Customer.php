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
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the customer type associated with the customer.
     */
    public function customerType()
    {
        return $this->belongsTo(CustomerType::class);
    }

    public function customer_visits()
    {
        return $this->hasMany(CustomerVisit::class);
    }
}
