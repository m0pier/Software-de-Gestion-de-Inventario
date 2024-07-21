@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Informacion de Producto</h1>
@endsection

@section('content')

    <div class="card-header">
        <div class="row">
            @can('Agregar productos')
                <div class="col-md">
                    <a href="{{ route('producto.create') }}" class="nav-link"> <span class="btn btn-primary float-right">+ Crear
                            nuevo producto</span></a>
                </div>
            @endcan
        </div>
    </div>
    <div class="card-body border border-primary">
        <div class="container">
            <div class="row">
                <div class="col-4 md-3 text-center">
                    <h2 class="text-center">{{ $producto->nombre }}</h2>
                    <img src="{{ asset($producto->imagen) }}" alt="noun" class="img-thumbnail"
                        style="width: 200px; height: 200px;">
                    @can('Borrar productos')
                        <a href="{{ route('proveedor.show', $producto->proveedor->id) }}" class="nav-link"> <span
                                class="btn btn-outline-primary w-75">Ver Proveedor</span></a>

                        @if ($producto->status == 1)
                            <a href="{{ route('productstatus', $producto) }}" class="nav-link"> <span
                                    class="btn btn-outline-primary w-75">Activo</span></a>
                        @else
                            <a href="{{ route('productstatus', $producto) }}" class="nav-link"> <span
                                    class="btn btn-outline-primary w-75">Desactivado</span></a>
                        @endif
                    @endcan

                </div>
                <div class="col">
                    <div class="col">
                        <h3 class="text-left"><strong>Información de Producto</strong></h3>
                    </div>
                    <div class="form-group col-md-6">
                        <strong><i class="fas fa-tag"></i>Nombre</strong>
                        <p class="text-muted">

                            {{ $producto->nombre }}
                        </p>
                        <hr>
                        <strong><i class="fas fa-address-card mr-1"></i>Proveedor</strong>
                        <p class="text-muted">
                            {{ $producto->proveedor->nombre }}

                        </p>
                        <hr>
                        <hr>
                        <strong><i class="fas fa-list"></i>Categoria</strong>
                        <p class="text-muted">
                            {{ $producto->categoria->nombre }}

                        </p>
                        <hr>
                        <strong><i class="fas fa-align-left"></i>Descripción</strong>
                        <p class="text-muted">
                            {{ $producto->descripcion }}

                        </p>
                        <hr>
                    </div>
                </div>
                <div class="col mt-5">
                    <strong><i class="fa fa-barcode"></i>Codigo</strong>
                    <p class="text-muted">
                        {{ $producto->codigo }}

                    </p>
                    <hr>
                    <strong><i class="fas fa-dollar-sign"></i>Precio</strong>
                    <p class="text-muted">
                        {{ $producto->precio }}

                    </p>
                    <hr>
                    <strong><i class="fa fa-archive"></i>Stock</strong>
                    <p class="text-muted">
                        {{ $producto->stock }}

                    </p>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
        <a href="{{ route('producto.index') }}" type="button" class="btn btn-primary float-right">Regresar</a>
    </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Productos de la misma categoria</h3>
        </div>

        <div class="card-body">
            {{-- Setup data for datatables --}}
            @php
                $heads = ['Imagen', 'Codigo', 'Nombre', 'Descripcion', 'Categoria', 'Precio', 'Stock'];
                $config = [
                    'order' => [[1, 'asc']],
                ];
            @endphp

            {{-- Minimal example / fill data using the component slot --}}
            <x-adminlte-datatable id="table6" :heads="$heads" head-theme="light" theme="dark" :config="$config"
                striped hoverable with-footer footer-theme="light" beautify>
                @foreach ($productos as $producto)
                    <tr>
                        <td><img src="{{ asset($producto->imagen) }}" alt="noun" class="img-thumbnail"
                                style="width: 150px; height: 125px;"></td>
                        <td>{{ $producto->codigo }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->categoria->nombre }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td>{{ $producto->stock }}</td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
    <div class="card-footer text-muted">
        <a href="{{ route('producto.index') }}" type="button" class="btn btn-primary float-right">Regresar</a>
    </div>


@endsection

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endsection

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@endsection
