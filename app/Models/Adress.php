<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    use HasFactory;

    protected $fillable = ['latitude', 'longtitude', 'adress'];

    public function places()
    {
        return $this->belongsToMany(Place::class, 'adress_place');
    }

}
