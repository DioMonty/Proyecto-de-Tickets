<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolConsultor extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_consult',
        'detalle',
        'estado',
    ];
}
