<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    use HasFactory;

    protected $primaryKey = 'idProducto';

    // Metodos de relación
    public function getMarca(){
        return $this->BelongsTo(Marca::class, 'idMarca', 'idMarca');
    }

    public function getCategoria(){
        return $this->BelongsTo(Categoria::class, 'idCategoria', 'idCategoria');
    }
}
