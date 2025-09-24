<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'cod_ticket',
        'nombre_ticket',
        'tipo_ticket',
        'oc_bolsa',
        'id_modulo',
        'tipo_costo',
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
        'fecha_resolucion',
        'num_hes',
        'factura_id',
        'status',
        'user_create'
    ];

    public function modulo() {
        return $this->belongsTo(Modulo::class, 'id_modulo');
    }
    public function estado() {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
    public function cliente() {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
    public function sociedad() {
        return $this->belongsTo(Sociedad::class, 'id_sociedad');
    }
    public function abap() {
        return $this->belongsTo(Consultor::class, 'id_abap');
    }
    public function funcional() {
        return $this->belongsTo(Consultor::class, 'id_funcional');
    }
    public function factura() {
        return $this->belongsTo(FacturaTicket::class, 'factura_id');
    }
    public function usuario() {
        return $this->belongsTo(Usuario::class, 'user_create');
    }
}
