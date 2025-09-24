<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_factura',
        'fecha_factura',
        'estado',
    ];
}
