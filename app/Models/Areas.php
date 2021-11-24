<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    use HasFactory;
    protected  $table = 'areas';
	protected $fillable =
	[
		'name',
		'name_responsable',
		'ci_responsable',
        'comunity',
        'bloque',
        'position',
        'status',
        'date_register',
        'user_id',
	];
}
