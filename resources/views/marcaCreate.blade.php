@extends('layouts.plantilla')
    @section('contenido')
        <h1>Alta de una marca</h1>

        <div class="alert bg-light p-4 col-8 mx-auto shadow">
            <form action="/marca/store" method="post">
                @csrf
                <div class="form-group">
                    <label for="mkNombre">Nombre de la marca</label>
                    <input type="text" name="mkNombre" value="{{ old('mkNombre') }}" class="form-control" id="mkNombre">
                </div>

                <button class="btn btn-dark my-3 px-4">Agregar marca</button>
                <a href="/" class="btn btn-outline-secondary">Volver a panel de marcas</a>
            </form>
        </div>

        {{-- Para mostrar valores de la validacion --}}
        @if ( $errors->any() )
            <div class="alert alert-danger p-4 col-8 mx-auto">
                <ul>
                    @foreach ( $errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    @endsection
