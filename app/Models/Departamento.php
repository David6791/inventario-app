<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
	protected  $table = 'departamentos';
	protected $fillable =
	[
		'nombre',
		'cod_depa',
		'user_create',
	];
}
