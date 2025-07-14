<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sociedad extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_sociedad',
        'razon_social',
        'ruc',
        'direccion',
        'estado',
    ];
}
