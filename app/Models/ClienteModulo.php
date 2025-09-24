<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteModulo extends Model
{
    use HasFactory;

    protected $table = 'cliente_modulos';
    protected $fillable = [
        'id_cliente',
        'id_modulo',
        'costo_soporte',
        'costo_proyecto',
        'costo_bolsa_hora',
        'estado',
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'id_modulo');
    }
}
