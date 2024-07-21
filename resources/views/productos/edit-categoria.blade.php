@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Categoria</h1>
@stop

@section('content')
    <div class="card">
        @php
            if (session()) {
                if (session('message') == 'ok') {
                    echo '  <x-adminlte-alert class="bg-teal text-uppercase" icon="fa fa-lg fa-thumbs-up" title="Done" dismissable>
                                Se ha guardado con exito!
                            </x-adminlte-alert>';
                }
            }
        @endphp
    </div>
    <div class="card-body">
        <form action="{{ route('categoria.update', $categoria) }}" method="post">
            @csrf
            @method('PUT')
            <x-adminlte-input type="text" name="nombre" label="NOMBRE" placeholder="Example: Metales"
                label-class="text-lightblue" value="{{ $categoria->nombre }}">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fa fa-user-circle text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <x-adminlte-input type="text" name="descripcion" label="DESCRIPCION" placeholder="Example: Todo tipo de metales"
                label-class="text-lightblue" value="{{ $categoria->descripcion }}">
                <x-slot name="prependSlot">
                    <div class="input-group-text">
                        <i class="fa fa-user-circle text-lightblue"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <a href="{{ route('producto.create') }}" class="btn btn-secondary">Volver</a>
            <x-adminlte-button class="btn-flat" type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save" />
        </form>
    </div>


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
