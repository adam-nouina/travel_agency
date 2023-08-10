<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image'];

    public function getCity(){
        return $this->belongsTo(City::class, 'city_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
