<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/********************************************************************************************************************
    Para poder crear un modelo usamos el comando: "php artisan make:controller NombreDelControladorController -r"
*********************************************************************************************************************/
class EjemploController extends Controller {
    // index
    public function index(){}
    
    // show || otro
    public function verRecurso(){}
    
    // create || store
    public function crearRecurso(){}
    
    // edit || update
    public function modificarRecurso(){}
    
    // destroy
    public function eliminarRecurso(){}

}
