<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultor extends Model
{
    use HasFactory;

    protected $table = 'consultors';

    protected $fillable = [
        'id_usuario',
        'telefono',
        'ruc',
        'banco',
        'cta_banco',
        'cta_cci',
        'cta_detraccion',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function roles()
    {
        return $this->hasMany(RolConsultor::class, 'id_consult');
    }

    public function modulos()
    {
        return $this->hasMany(ConsultorModulo::class, 'id_consultor');
    }

}
