<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';
    protected  $fillable =
    [
    	'cod_prov',
    	'name_province',
        'cod_depa',
        'id_department',
        'user_create',

    ];
}
