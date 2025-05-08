<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormuleProduit extends Model
{
    /** @use HasFactory<\Database\Factories\FormuleProduitFactory> */

    use HasFactory;
    public function formule()
    {
        return $this->belongsTo(Bien_etre::class);
    }
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
