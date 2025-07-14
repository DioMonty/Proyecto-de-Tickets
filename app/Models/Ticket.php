<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_ticket',
        'tipo_ticket',
        'oc_bolsa',
        'id_modulo',
        'id_estado',
        'id_cliente',
        'id_sociedad',
        'solicitante',
        'id_abap',
        'hora_abap',
        'costo_abap',
        'id_funcional',
        'hora_funcional',
        'costo_funcional',
        'costo_total',
        'total_horas',
        'fecha_prd',
        'fecha_inicio',
        'fecha_resolucion'
    ];

}
