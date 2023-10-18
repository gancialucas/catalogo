<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;

class MarcaController extends Controller {
    /* Display a listing of the resource. Enlista de forma general. */
    public function index() {
        // Obtenemos listado de marcas.
        $marcas = Marca::all();

        /*
            Para usar paginador:
                $marcas = Marca::simplePaginate(3);

                Para usar paginate debemos ir a 'app/Providers/AppServiceProvider.php'
                y colocar "Paginator::useBootstrapFive();" en metodo boot
                    $marcas = Marca::paginate(3);

                Recordar que en la view debemos usar:
                    {{ $marcas->links() }}

            Si se usa paginador no es necesario usar: "$marcas = Marca::all();"
        */

        // Retornamos vista con el listado de marcas.
        return view('marcas', ['marcas' => $marcas]);
    }

    /* Show the form for creating a new resource. */
    public function create() {
        // Mostramos la vista
        return view('marcaCreate');
    }


    // Creamos nuestro propio metodo de validación
    private function validateForm(Request $request){
        /*
            Primer regla:
                Dentro del array se escribe [ 'campo' => 'reglas' ]
            Segunda regla:
                Como un segundo parametro podemos
                colocar mensajes personalizados para las diferentes
                pruebas de validacion.

            Ejemplo final:
                [
                    'campo_1' => 'reglas',
                    'campo_2' => 'reglas',
                    'campo_3' => 'reglas',
                ],
                [
                    'campo.regla' => 'mensaje'
                ]
        */
        $request->validate(
            ['mkNombre' => 'required|unique:marcas|min:2|max:15'],
            [
                'mkNombre.required' => 'Por favor, ingrese un valor',
                'mkNombre.unique' => 'No pueden haber dos marcas con el mismo nombre',
                'mkNombre.min' => 'El campo "Nombre de la marca" debe tener mínimo 2 caracteres',
                'mkNombre.max' => 'El campo "Nombre de la marca" debe tener máximo 15 caracteres'
            ]
        );
    }


    /* Store a newly created resource in storage. */
    public function store(Request $request) {
        /*
            Validación
                Usamos un metodo de la clase request llamado validate()
                Dentro, pasamos por parametro el $request ya que contendrá
                todos los valores pasados por el formulario.
        */
        $this -> validateForm($request);

        // Obtenemos el valor del formulario
        $mkNombre = request()->mkNombre;

        try {
            /****************************
                Cargar datos a la DB
            *****************************/

                // Instanciamos
                $Marca = new Marca;

                // Asignamos valor a los atributos del objeto Marca
                $Marca -> mkNombre = $mkNombre;

                // Guardamos en tabla Marca
                $Marca -> save();

            /***********************************************************************
                Puede saltar un error y es porque faltan estos dos campos en la
                base de datos:
                    - 'updated_at'
                    - 'created_at'
                Dos opciones para arreglarlo:
                    1. Ir al model y colocar la siguiente linea de codigo:
                        "public timestamps = false;"
                    2. Agregar los campos a la tabla
            ************************************************************************/

            return redirect('/')
                ->with ([
                    'mensaje' => 'La marca: "'.$mkNombre.'" fue agregada con éxito 👍🏻',
                    'css' => 'success'
                ]);
        } catch (\Throwable $th) {
            return redirect('/')
                ->with ([
                    'mensaje' => 'No se pudo agregar el nombre de la marca: "'.$mkNombre.'" 👎🏻',
                    'css' => 'danger'
                ]);
        }
    }

    /* Display the specified resource. Enlista lo específico. */
    public function show(string $id) {
        //
    }

    /* Show the form for editing the specified resource. */
    public function edit($id) {
        // Obtenemos nombre de la marca - CAMBIAR NOMBRE de la PRIMARYKEY desde MODEL
        $Marca = Marca::find($id);

        return view('marcaEdit', [
            'Marca'=>$Marca
        ]);
    }

    /* Update the specified resource in storage. */
    public function update() {
        $mkNombre = request()->mkNombre;
        $idMarca = request()->idMarca;

        try {
            $Marca = Marca::find($idMarca);
            $Marca -> mknombre = $mkNombre;
            $Marca->save();

            return redirect('/')
            ->with ([
                'mensaje' => 'La marca: "'.$mkNombre.'" fue actualizada con éxito 👍🏻',
                'css' => 'success'
            ]);
        } catch (\Throwable $th) {
            return redirect('/')
                ->with ([
                    'mensaje' => 'No se pudo actualizar el nombre de la marca por: "'.$mkNombre.'" 👎🏻',
                    'css' => 'danger'
                ]);
        }
    }

    /* A view is displayed before the destroy method is executed. */
    public function confirm($id){
        $Marca = Marca::find($id);

        // Comprobamos si hay un producto asociado a la marca
        $Producto = Producto::where('idMarca', $id)->first();
        if ($Producto) {
            return redirect('/')
            ->with ([
                'mensaje' => 'La marca: "'.$Marca->mkNombre.'" tiene un/varios producto asociado ⚠',
                'css' => 'warning'
            ]);
        }

        return view('marcaDelete', [
            'Marca'=>$Marca
        ]);
    }

    /* Remove the specified resource from storage. */
    public function destroy() {
        $mkNombre = request() -> mkNombre;
        $idMarca = request() -> idMarca;

        try {
            $Marca = Marca::find($idMarca);
            $Marca -> delete();

            /*
                Forma en eloquent directamente llamando al Modelo
                    Marca::destroy($idMarca);
            */

            return redirect('/')
            ->with ([
                'mensaje' => 'La marca: "'.$mkNombre.'" fue borrada con éxito 👍🏻',
                'css' => 'success'
            ]);
        } catch (\Throwable $th) {
            return redirect('/')
                ->with ([
                    'mensaje' => 'No se pudo borrar la marca: "'.$mkNombre.'" 👎🏻',
                    'css' => 'danger'
                ]);
        }
    }
}
