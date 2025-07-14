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
}
