@extends('layouts.plantilla')
    @section('contenido')
        <h1>Baja de una categoría</h1>

        <div class="alert alert-danger col-6 mx-auto p-4 text-center">
            <p class="bg-white rounded-2 p-1">Se eliminará la categoría: <span class="lead">{{ $Categoria->catNombre }}</span></p>

            <form action="/categoria/destroy" method="post">
                @method('delete')
                @csrf

                <input type="hidden" name="catNombre" value="{{ $Categoria->catNombre }}">
                <input type="hidden" name="idCategoria" value="{{ $Categoria->idCategoria }}">

                <button class="btn btn-danger btn-block mt-1">Confirmar baja</button>

                <a href="/categoria" class="btn btn-light btn-block mt-1">Volver a panel</a>
            </form>
        </div>

    @endsection
