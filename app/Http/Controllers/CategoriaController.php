<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class CategoriaController extends Controller {
    /* Display a listing of the resource. Enlista de forma general. */
    public function index() {
        // Obtenemos listado de categorias.
        $categoria = Categoria::all();

        // Retornamos vista con el listado de categorias.
        return view('categorias', ['categorias' => $categoria]);
    }

    /* Show the form for creating a new resource. */
    public function create() {
        return view('categoriaCreate');
    }

    private function validateForm(Request $request){
        $request->validate(
            [
                'catNombre' => 'required|unique:categorias|min:2|max:25'
            ],
            [
                'catNombre.required' => 'Por favor, ingrese un valor',
                'catNombre.unique' => 'No pueden haber dos categorías con el mismo nombre',
                'catNombre.min' => 'El campo "Nombre de la categoría" debe tener mínimo 2 caracteres',
                'catNombre.max' => 'El campo "Nombre de la categoría" debe tener máximo 25 caracteres'
            ]
        );
    }

    /* Store a newly created resource in storage. */
    public function store(Request $request) {
        $this->validateForm($request);
        $catNombre = request()->catNombre;

        try {
            $Categoria = new Categoria;
            $Categoria -> catNombre = $catNombre;
            $Categoria -> save();
            return redirect('/categorias')
                ->with ([
                    'mensaje' => 'La categoría: "'.$catNombre.'" fue agregada con éxito 👍🏻',
                    'css' => 'success'
                ]);
        } catch (\Throwable $th) {
            return redirect('/categorias')
                ->with ([
                    'mensaje' => 'No se pudo agregar la categoría: "'.$catNombre.'" 👎🏻',
                    'css' => 'danger'
                ]);
        }
    }

    /* Display the specified resource. Enlista lo específico. */
    public function show(string $id) {
        //
    }

    /* Show the form for editing the specified resource. */
    public function edit(string $id) {
        $Categoria = Categoria::find($id);

        return view('categoriaEdit', [
            'Categorias'=>$Categoria
        ]);
    }

    /* Update the specified resource in storage. */
    public function update() {
        $catNombre = request('catNombre');
        $idCategoria = request('idCategoria');

        try {
            $Categoria = Categoria::find($idCategoria);
            $Categoria -> catNombre = $catNombre;
            $Categoria->save();

            return redirect('/categorias')
            ->with ([
                'mensaje' => 'La categoría: "'.$catNombre.'" fue actualizada con éxito 👍🏻',
                'css' => 'success'
            ]);
        } catch (\Throwable $th) {
            return redirect('/categorias')
                ->with ([
                    'mensaje' => 'No se pudo actualizar la categoría por: "'.$catNombre.'" 👎🏻',
                    'css' => 'danger'
                ]);
        }
    }


    /* A view is displayed before the destroy method is executed. */
    public function confirm($id){
        $Categoria = Categoria::find($id);

        // Comprobamos si hay un producto asociado a la Categoria
        $Producto = Producto::where('idCategoria', $id)->first();
        if ($Producto) {
            return redirect('/categorias')
            ->with ([
                'mensaje' => 'La marca: "'.$Categoria->catNombre.'" tiene un/varios producto asociado ⚠',
                'css' => 'warning'
            ]);
        }

        return view('categoriaDelete', [
            'Categoria'=>$Categoria
        ]);
    }

    /* Remove the specified resource from storage. */
    public function destroy() {
        $catNombre = request('catNombre');
        $idCategoria = request('idCategoria');

        try {
            $Categoria = Categoria::find($idCategoria);
            $Categoria->delete();

            return redirect('/categorias')
            ->with ([
                'mensaje' => 'La categoria: "'.$catNombre.'" fue borrada con éxito 👍🏻',
                'css' => 'success'
            ]);
        } catch (\Throwable $th) {
            return redirect('/categorias')
                ->with ([
                    'mensaje' => 'No se pudo borrar la marca: "'.$catNombre.'" 👎🏻',
                    'css' => 'danger'
                ]);
        }
    }
}
