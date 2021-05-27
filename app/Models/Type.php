<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['type'];
    
    public function places()
    {
        return $this->belongsToMany(Place::class, 'place_type');
    }
}
