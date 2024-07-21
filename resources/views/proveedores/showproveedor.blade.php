@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Informacion de proveedor</h1>
@endsection

@section('content')

    <div class="card-header">
        <div class="row">
            <div class="col-md">
                <a href="{{ route('proveedor.create') }}" class="nav-link"> <span class="btn btn-primary float-right">+ Crear
                        nuevo</span></a>
            </div>
        </div>
    </div>
    <div class="card-body border border-primary">
        <div class="container">
            <div class="row">
                <div class="col-4 md-3 text-center">
                    <h2 class="text-center">{{ $proveedor->nombre }}</h2>
                    <a href="{{ route('proveedor.show', $proveedor) }}"> <img src="{{ asset($proveedor->imagen) }}"
                            alt="noun" class="img-thumbnail" style="width: 200px; height: 200px;"></a>
                    <a href="{{ route('compra.create') }}" class="nav-link"> <span class="btn btn-outline-primary w-75">Comprar Producto</span></a>

                </div>
                <div class="col">
                    <div class="col">
                        <h3 class="text-left"><strong>Información de Proveedor</strong></h3>
                    </div>
                    <div class="form-group col-md-6">
                        <strong><i class="fab fa-product-hunt mr-1"></i>Nombre</strong>
                        <p class="text-muted">

                                {{ $proveedor->nombre }}
                        </p>
                        <hr>
                        <strong><i class="far fa-id-card mr-1"></i>Tipo de documento</strong>
                        <p class="text-muted">
                             RUC

                        </p>
                        <hr>
                        <strong><i class="fas fa-address-card mr-1"></i>Numero de Documento</strong>
                        <p class="text-muted">
                            {{ $proveedor->ruc }}

                        </p>
                        <hr>
                    </div>
                </div>
                <div class="col mt-5">
                    <strong><i class="fas fa-phone-alt mr-1"></i>Telefono</strong>
                    <p class="text-muted">
                        {{ $proveedor->telefono }}

                    </p>
                    <hr>
                    <strong><i class="far fa-envelope mr-1"></i>email</strong>
                    <p class="text-muted">
                        {{ $proveedor->email }}

                    </p>
                    <hr>
                    <strong><i class="fas fa-map-marked-alt mr-1"></i>dirección</strong>
                    <p class="text-muted">
                        {{ $proveedor->direccion }}

                    </p>
                    <hr>
                </div>
            </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Productos del proveedor</h3>
            </div>
            <div class="card-body">
                {{-- Setup data for datatables --}}
                @php
                    $heads = ['Imagen','Codigo', 'Nombre', 'Descripcion', 'Categoria', 'Precio', 'Stock'];
                    $config = [
                        'order' => [[1, 'asc']]
                    ];
                @endphp

                {{-- Minimal example / fill data using the component slot --}}
                <x-adminlte-datatable id="table6" :heads="$heads" head-theme="light" theme="dark" :config="$config" striped
                    hoverable with-footer footer-theme="light" beautify>
                    @foreach ($productos as $producto)
                        <tr>
                            <td><img src="{{ asset($producto->imagen) }}"
                                alt="noun" class="img-thumbnail" style="width: 150px; height: 125px;"></td>
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
    </div>
    <div class="card-footer text-muted">
        <a href="{{ route('proveedor.index') }}" type="button" class="btn btn-primary float-right">Regresar</a>
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
