<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = ['place'];

    public function types()
    {
        return $this->belongsToMany(Type::class, 'place_type');
    }

    public function adresses()
    {
        return $this->belongsToMany(Adress::class, 'adress_place');
    }
}
