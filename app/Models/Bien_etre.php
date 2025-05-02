<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien_etre extends Model
{
    /** @use HasFactory<\Database\Factories\BienEtreFactory> */
    use HasFactory;
    public function produits()
    {
        return $this->hasMany(Produit::class);
    }
}
