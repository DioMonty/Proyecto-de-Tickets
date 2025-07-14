<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultorModulo extends Model
{
    use HasFactory;

    protected $table = 'consultor_modulos';
    protected $fillable = [
        'id_consultor',
        'id_modulo',
        'costo_funcional',
        'costo_cliente',
        'estado',
    ];
    public function consultor()
    {
        return $this->belongsTo(Consultor::class, 'id_consultor');
    }
    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'id_modulo');
    }

}
