@extends('layouts.plantilla')
    @section('contenido')
        <h1>Baja de una marca</h1>

        <div class="alert alert-danger col-6 mx-auto p-4 text-center">
            <p class="bg-white rounded-2 p-1">Se eliminará la marca: <span class="lead">{{ $Marca->mkNombre }}</span></p>

            <form action="/marca/destroy" method="post">
                @method( 'delete' )
                @csrf

                <input type="hidden" name="mkNombre" value="{{ $Marca->mkNombre }}">
                <input type="hidden" name="idMarca" value="{{ $Marca->idMarca }}">

                <button class="btn btn-danger btn-block mt-1">Confirmar baja</button>

                <a href="/" class="btn btn-light btn-block mt-1">Volver a panel</a>
            </form>
        </div>

    @endsection
