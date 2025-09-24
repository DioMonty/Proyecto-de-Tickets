<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoFechaTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_ticket',
        'id_estado',
        'fecha_estado',
        'descripcion',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'id_ticket_estado');
    }

}
