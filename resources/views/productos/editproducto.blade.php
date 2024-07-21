@extends('adminlte::page')

@section('title', 'Agregar Producto')

@section('content_header')
    <h1>Agregar Producto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('message') == 'ok')
                <x-adminlte-alert class="bg-teal text-uppercase" icon="fa fa-lg fa-thumbs-up" title="Done" dismissable>
                    Se ha guardado con éxito!
                </x-adminlte-alert>
            @endif

            <form action="{{ route('producto.update', $producto) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <x-adminlte-input-file name="imagen" label="SUBIR IMAGEN" label-class="text-lightblue"
                    placeholder="Escoja la imagen" igroup-size="lg" legend="Escoja">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-file-upload"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>

                <x-adminlte-input type="text" name="nombre" label="Nombre del producto" placeholder="Ex: Moladora"
                    label-class="text-lightblue" value="{{ $producto->nombre }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-tag"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input type="text" name="descripcion" label="Descripción"
                    placeholder="Ex: Moladora con doble rosca" label-class="text-lightblue"
                    value="{{ $producto->descripcion }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-align-left"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input type="text" name="codigo" label="Código" placeholder="Ex: moladoracategor654"
                    label-class="text-lightblue" value="{{ $producto->codigo }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-barcode" aria-hidden="true"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input type="number" name="precio" label="Precio de Venta" placeholder="54"
                    label-class="text-lightblue" value="{{ $producto->precio }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-select name="id_categoria" label="Categoría" label-class="text-lightblue" igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-list"></i>
                        </div>
                    </x-slot>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ $categoria->id == $producto->id_categoria ? 'selected' : '' }}>
                            {{ $categoria->nombre }} -- {{ $categoria->descripcion }}
                        </option>
                    @endforeach
                </x-adminlte-select>


                <x-adminlte-select name="id_proveedor" label="Proveedor" label-class="text-lightblue" igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-list"></i>
                        </div>
                    </x-slot>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}"
                            {{ $proveedor->id == $producto->id_proveedor ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </x-adminlte-select>


                <x-adminlte-button class="btn-flat" type="submit" label="Guardar" theme="success" icon="fas fa-save" />
            </form>
        </div>
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
