<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTicketUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_ticket',
        'id_consultor',
        'id_rol',
        'estado',
    ];

}
