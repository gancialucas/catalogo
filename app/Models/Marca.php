<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**********************************************************************************************
    Para poder crear un modelo usamos el comando: "php artisan make:model NombreDelModelo"
***********************************************************************************************/
class Marca extends Model {
    use HasFactory;

    protected $primaryKey = 'idMarca';
}
