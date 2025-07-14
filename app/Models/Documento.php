<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_ticket_estado',
        'nombre_original',
        'extension',
        'ruta_documento',
        'tamano_bytes',
        'subido_por',
        'fecha_subida',
        'estado',
    ];

}
