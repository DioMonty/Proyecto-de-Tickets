<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSociety extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cliente',
        'id_sociedad',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_cliente');
    }

    public function sociedad()
    {
        return $this->belongsTo(Sociedad::class, 'id_sociedad');
    }
}
