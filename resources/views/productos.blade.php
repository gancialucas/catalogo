@extends('layouts.plantilla')
    @section('contenido')

        <h1>Panel de administración de productos</h1>

        @if ( session('mensaje') )
            <div class="alert alert-{{ session('css') }}">
                {{ session('mensaje') }}
            </div>
        @endif

        <div class="row my-3 text-start">
            <div class="col-10"></div>
            <div class="col-2 text-end mb-3">
                <a href="/producto/create" class="btn btn-outline-secondary">
                    <i class="bi bi-plus-square"></i>&nbsp;Agregar&nbsp;
                </a>
            </div>
        </div>

        <hr>

        @foreach( $productos as $producto )
            <div class="row mt-3">
                <figure class="col-3">
                    <img src="/imgs/productos/{{ $producto->prdImagen }}" class="img-fluid img-thumbnail w-75">
                </figure>

                <div class="col-auto">
                    <h2>{{ $producto->prdNombre }}</h2>

                    <span class="precio2">${{ $producto->prdPrecio }}</span>

                    <p class="pt-3 m-0">Marca: {{ $producto->getMarca->mkNombre }}</p>
                    <p>Categoría: {{ $producto->getCategoria->catNombre }}</p>
                </div>

                <div class="col-auto">
                    <a href="/producto/edit/{{ $producto->idProducto }}" class="btn btn-outline-secondary me-1">
                        <i class="bi bi-pencil-square"></i>&nbsp;Modificar&nbsp;
                    </a>
                    <a href="/producto/delete/{{ $producto->idProducto }}" class="btn btn-outline-secondary me-1">
                        <i class="bi bi-trash"></i>&nbsp;Eliminar&nbsp;
                    </a>
                </div>
            </div>
        @endforeach

        {{ $productos->links() }}

    @endsection
