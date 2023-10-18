<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('inicio');
});

/*
|--------------------------------------------------------------------------
| CRUD de Marcas
|--------------------------------------------------------------------------
|
| El action, despues de la uri/peticion, cambia y se maneja con un array
| con una referencia/path al controlador y .
|   - Para ello importamos con el use la ruta del archivo NombreController.
*/
Route::get('/', [ MarcaController::class, 'index' ]);
Route::get('/marca/create', [ MarcaController::class, 'create' ]);
Route::post('/marca/store', [ MarcaController::class, 'store' ]);
Route::get('/marca/edit/{id}', [ MarcaController::class, 'edit' ]);
Route::put('/marca/update', [ MarcaController::class, 'update' ]);
Route::get('/marca/delete/{id}', [ MarcaController::class, 'confirm' ]);
Route::delete('/marca/destroy', [ MarcaController::class, 'destroy' ]);

/*
|--------------------------------------------------------------------------
| CRUD de Categorias
|--------------------------------------------------------------------------
*/
Route::get('/categorias', [CategoriaController::class, 'index']);
Route::get('/categoria/create', [CategoriaController::class, 'create']);
Route::post('/categoria/store', [CategoriaController::class, 'store']);
Route::get('/categoria/edit/{id}', [CategoriaController::class, 'edit']);
Route::put('/categoria/update', [CategoriaController::class, 'update']);
Route::get('/categoria/delete/{id}', [CategoriaController::class, 'confirm']);
Route::delete('/categoria/destroy', [CategoriaController::class, 'destroy']);

/*
|--------------------------------------------------------------------------
| CRUD de Productos
|--------------------------------------------------------------------------
*/
Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/producto/create', [ProductoController::class, 'create']);
Route::post('/producto/store', [ProductoController::class, 'store']);
Route::get('/producto/edit/{id}', [ProductoController::class, 'edit']);
Route::put('/producto/update', [ProductoController::class, 'update']);
Route::get('/producto/delete/{id}', [ProductoController::class, 'confirm']);
Route::delete('/producto/destroy', [ProductoController::class, 'destroy']);
