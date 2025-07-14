<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTicketCosto extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_ticket',
        'rol',
        'condicion',
        'horas',
        'estado',
    ];

}
