<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'phone',
        'email',
        'role',
        'status',
        'password',
    ];

    public function societies()
    {
        return $this->hasMany(UserSociety::class, 'id_cliente');
    }

}