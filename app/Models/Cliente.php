<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','ruc','telefono','direccion','email'];


    public  function sales()
    {
        return $this->hasMany(Sale::class);
    }

}


