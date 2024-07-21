@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Informacion de cliente</h1>
@endsection

@section('content')

    <div class="card-header">
    </div>
    <div class="card-body border border-primary">
        <div class="container">
            <div class="row">
                <div class="col-4 md-3 text-center">
                    <h2 class="text-center">{{ $cliente->nombres }}</h2>
                    <a href="" class="nav-link"> <span class="btn btn-outline-primary w-75">Productos</span></a>
                    <a href="" class="nav-link"> <span class="btn btn-outline-primary w-75">Comprar Producto</span></a>

                </div>
                <div class="col">
                    <div class="col">
                        <h3 class="text-left"><strong>Información de cliente</strong></h3>
                    </div>
                    <div class="form-group col-md-6">
                        <strong><i class="fab fa-product-hunt mr-1"></i>Nombre</strong>
                        <p class="text-muted">

                                {{ $cliente->nombres }}
                        </p>
                        <hr>
                        <strong><i class="far fa-id-card mr-1"></i>Tipo de documento</strong>
                        <p class="text-muted">
                             Cedula

                        </p>
                        <hr>
                        <strong><i class="fas fa-address-card mr-1"></i>Numero de Documento</strong>
                        <p class="text-muted">
                            {{ $cliente->cedula }}

                        </p>
                        <hr>
                    </div>
                </div>
                <div class="col mt-5">
                    <strong><i class="fas fa-phone-alt mr-1"></i>Telefono</strong>
                    <p class="text-muted">
                        {{ $cliente->telefono }}

                    </p>
                    <hr>
                    <strong><i class="far fa-envelope mr-1"></i>email</strong>
                    <p class="text-muted">
                        {{ $cliente->email }}

                    </p>
                    <hr>
                    <strong><i class="fas fa-map-marked-alt mr-1"></i>dirección</strong>
                    <p class="text-muted">
                        {{ $cliente->direccion }}

                    </p>
                    <hr>
                </div>
            </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            <a href="{{ route('cliente.index') }}" type="button" class="btn btn-primary float-right">Regresar</a>
        </div>
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
