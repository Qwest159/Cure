<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chambre extends Model
{
    protected $fillable = [
        'nom',
        'img_path',
        'nbr_personnes',
        'nbr_lit',
        'nbr_sdb',
        'date_debut',
        'date_fin',
        'description',
        'prix',
        'jours',
    ];
    /** @use HasFactory<\Database\Factories\ChambreFactory> */
    use HasFactory;
}
