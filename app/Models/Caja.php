<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;
    protected $fillable = ['direccion','estab','ptoEmi','companie_id'];


    // una caja pertenece a una compañia

    public function compania ()
    {
        return $this->belongsTo(Company::class);
    }
}
