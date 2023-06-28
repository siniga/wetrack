<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

}
