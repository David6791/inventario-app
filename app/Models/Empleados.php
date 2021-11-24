<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'apellidos',
        'email',
        'direccion',
        'profile',
        'cargo',
        'telefono',
        'status',
        'image',
        'ci',
        'fecha_contratacion'
    ];
}
