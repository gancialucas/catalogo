<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;
use Termwind\Components\Raw;

class ProductoController extends Controller
{
    /* Display a listing of the resource. */
    public function index() {
        $productos = Producto::with(['getMarca', 'getCategoria'])->paginate(3);

        return view('productos', [
            'productos'=>$productos
        ]);
    }

    /* Show the form for creating a new resource. */
    public function create() {
        $Marca = Marca::all();
        $Categoria = Categoria::all();

        return view('productoCreate', [
            'marcas'=>$Marca,
            'categorias'=>$Categoria
        ]);
    }

    private function validateForm(Request $request, $idProducto = null){
        $request->validate(
            [
                'prdNombre'=>'required|unique:productos,prdNombre,'.$idProducto.',idProducto|min:3|max:30',
                'prdPrecio' => 'required|numeric',
                'prdDescripcion' => 'required|min:10|max:220',
                'prdImagen' => 'image',
                'idMarca' => 'required',
                'idCategoria' => 'required'
            ],
            [
                'prdNombre.required' => 'Por favor, ingrese un valor',
                'prdNombre.unique'=>'El "Nombre del producto" ya existe.',
                'prdNombre.min' => 'El campo "Nombre del producto" debe tener mínimo 2 caracteres',
                'prdNombre.max' => 'El campo "Nombre del producto" debe tener máximo 25 caracteres',

                'prdPrecio.required' => 'Por favor, ingrese un valor',
                'prdPrecio.numeric' => 'El campo "Precio del producto" debe ser un número',

                'prdDescripcion.required' => 'Por favor, ingrese una descripción',
                'prdDescripcion.min' => 'El campo "Descripción del producto" debe tener mínimo 10 caracteres',
                'prdDescripcion.max' => 'El campo "Descripción del producto" debe tener máximo 220 caracteres',

                'prdImagen.image' => 'Por favor, coloque una imagen',

                'idMarca.required' => 'Por favor, seleccione una marca',
                'idCategoria.required' => 'Por favor, seleccione una categoría',
            ]
        );
    }

    // Se crea una función para la subida de imagenes que retorna un string (nombre de la imagen)
    private function uploadImg(Request $request):string {
        /*
            Si no enviaron una archivo de imagen "store"
                Nombre de la imagen por default.
        */

        $prdImagen = 'noDisponible.png';

        /*
            Si no enviaron una archivo de imagen "upload"
                Nombre de la imagen por default.
        */
        if ($request -> has('imgActual')) {
            $prdImagen = request() -> imgActual;
        }

        /*
             Si enviaron una imagen
                - Se debe subir en /imgs/productos
        */

        if ($request->file('prdImagen')) {
            // Traemos el archivo
            $file = $request->file('prdImagen');

            // Renombrado:
            $time = time();
            $extension = $file->getClientOriginalExtension();

            $prdImagen = $time .'.'.$extension;

            // Copiar el archivo imagen
            $file->move(public_path('imgs/productos/'), $prdImagen);
        }

        return $prdImagen;
    }

    /* Store a newly created resource in storage. */
    public function store(Request $request) {
        $this->validateForm($request);

        $prdNombre = $request->prdNombre;
        $prdPrecio = $request->prdPrecio;
        $prdDescripcion = $request->prdDescripcion;

        $idMarca = $request->idMarca;
        $idCategoria = $request->idCategoria;

        try {
            $Producto = new Producto;

            $Producto -> prdNombre = $prdNombre;
            $Producto -> prdPrecio = $prdPrecio;
            $Producto -> prdDescripcion = $prdDescripcion;

            // Subimos img
            $Producto -> prdImagen = $this->uploadImg($request);

            $Producto -> prdActivo = 1;
            $Producto -> idMarca = $idMarca;
            $Producto -> idCategoria = $idCategoria;

            $Producto -> save();

            return redirect('/productos')
                ->with ([
                    'mensaje' => 'El producto: "'.$prdNombre.'" fue agregado con éxito 👍🏻',
                    'css' => 'success'
                ]);
        } catch (\Throwable $th) {
            return redirect('/productos')
            ->with ([
                'mensaje' => 'No se pudo agregar el producto: "'.$prdNombre.'" 👎🏻',
                'css' => 'danger'
            ]);
        }
    }

    /* Display the specified resource. */
    public function show(Producto $producto) {
        //
    }

    /* Show the form for editing the specified resource. */
    public function edit($id) {
        $Marcas = Marca::all();
        $Categorias = Categoria::all();

        $Producto = Producto::find($id);

        return view('productoEdit', [
            'marcas' => $Marcas,
            'categorias' => $Categorias,
            'Producto' => $Producto
        ]);
    }

    /* Update the specified resource in storage. */
    public function update(Request $request) {
        /*
            Plan de acción recomendado:
                1. validación
                2. subir imgs
                3. completar el update
        */

        // Validamos los datos ingresados por formulario
        $this->validateForm($request, $request->idProducto);

        // Realizamos paso 2.
        $prdImagen = $this->uploadImg($request);

        /*
            Realizar paso 3.
                Tomamos el valor del id
        */
        $idProducto = request()->idProducto;

        // Capturamos los valores enviados por formulario para colocarlos en una variable
        $prdNombre = $request->prdNombre;
        $prdPrecio = $request->prdPrecio;
        $prdDescripcion = $request->prdDescripcion;

        $idMarca = $request->idMarca;
        $idCategoria = $request->idCategoria;

        try {
            $Producto = Producto::find($idProducto);

            $Producto -> prdNombre = $prdNombre;
            $Producto -> prdPrecio = $prdPrecio;
            $Producto -> prdDescripcion = $prdDescripcion;
            $Producto -> prdImagen = $prdImagen;
            $Producto -> prdActivo = 1;
            $Producto -> idMarca = $idMarca;
            $Producto -> idCategoria = $idCategoria;

            $Producto->save();

            return redirect('/productos')
            ->with ([
                'mensaje' => 'El producto: "'.$prdNombre.'" fue actualizada con éxito 👍🏻',
                'css' => 'success'
            ]);
        } catch (\Throwable $th) {
            return redirect('/productos')
                ->with ([
                    'mensaje' => 'No se pudo actualizar el producto: "'.$prdNombre.'" 👎🏻',
                    'css' => 'danger'
                ]);
        }
    }

    /* A view is displayed before the destroy method is executed. */
    public function confirm($id){
        $Producto = Producto::with(['getMarca', 'getCategoria'])->find($id);

        return view('productoDelete', [
            'Producto'=>$Producto
        ]);
    }

    /* Remove the specified resource from storage. */
    public function destroy() {
        $prdNombre = request() -> prdNombre;
        $idProducto = request() -> idProducto;

        try {
            Producto::destroy($idProducto);

            return redirect('/productos')
            ->with ([
                'mensaje' => 'El producto: "'.$prdNombre.'" fue borrado con éxito 👍🏻',
                'css' => 'success'
            ]);
        } catch (\Throwable $th) {
            return redirect('/productos')
                ->with ([
                    'mensaje' => 'No se pudo borrar el producto: "'.$prdNombre.'" 👎🏻',
                    'css' => 'danger'
                ]);
        }
    }
}
