<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    /** @use HasFactory<\Database\Factories\DateFactory> */
    use HasFactory;
    public function chambres()
    {
        return $this->belongsToMany(Chambre::class, 'chambre_dates');
    }
}
