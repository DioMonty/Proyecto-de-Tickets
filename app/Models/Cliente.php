<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $fillable = [
        'descripcion',
        'razon_social',
        'ruc',
        'direccion',
        'email',
        'estado',
    ];
    public function modulos()
    {
        return $this->hasMany(ClienteModulo::class, 'id_cliente');
    }

}
