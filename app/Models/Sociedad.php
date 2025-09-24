<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sociedad extends Model
{
    use HasFactory;

    protected $table = 'sociedads';

    protected $fillable = [
        'id_cliente',
        'nombre_sociedad',
        'razon_social',
        'ruc',
        'direccion',
        'estado',
    ];

    function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
