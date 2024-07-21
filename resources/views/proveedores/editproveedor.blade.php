@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar un Proveedor</h1>
@endsection

@section('content')
    <p>Ingrese la información que desea actualizar</p>
    <div class="card">
        @if (session('message') == 'ok')
            <x-adminlte-alert class="bg-teal text-uppercase" icon="fa fa-lg fa-thumbs-up" title="Done" dismissable>
                ¡Se ha guardado con éxito!
            </x-adminlte-alert>
        @endif
        <div class="card-body">
            <form method="post" action="{{ route('proveedor.update', $proveedor)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                {{-- imagenes --}}
                <x-adminlte-input-file name="imagen" label="SUBIR IMAGEN" label-class="text-lightblue"
                    placeholder="Escoja la imagen " igroup-size="lg" legend="Escoja" multiple>
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-file-upload"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
                {{-- Nombre --}}
                <x-adminlte-input type="text" name="nombre" label="NOMBRE" placeholder="Example: Still"
                    label-class="text-lightblue" value="{{ $proveedor->nombre }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-user-circle text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                {{-- Cédula --}}
                <x-adminlte-input type="text" name="ruc" label="RUC" placeholder="Example: 1718094056001"
                    label-class="text-lightblue" value="{{ $proveedor->ruc }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-address-card text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                {{-- Email --}}
                <x-adminlte-input type="text" name="email" label="Email" placeholder="Example: info@test.com"
                    label-class="text-lightblue" value="{{ $proveedor->email }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-envelope text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                {{-- Teléfono --}}
                <x-adminlte-input type="text" name="telefono" label="TELÉFONO" placeholder="Example: 0988349826"
                    label-class="text-lightblue" value="{{ $proveedor->telefono }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-phone text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                {{-- Dirección --}}
                <x-adminlte-input type="text" name="direccion" label="DIRECCIÓN"
                    placeholder="Example: Calle las alondras" label-class="text-lightblue" value="{{ $proveedor->direccion }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-home text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                {{-- Botón --}}
                <x-adminlte-button class="btn-flat" type="submit" label="Guardar" theme="success"
                    icon="fas fa-lg fa-save" />
            </form>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@endsection

@section('js')

@endsection
