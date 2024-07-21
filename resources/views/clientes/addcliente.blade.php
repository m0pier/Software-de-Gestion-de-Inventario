@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Agregar un cliente</h1>
@stop

@section('content')
    <p>Ingrese la información del cliente para crear un registro</p>
    <div class="card">
        @if (session('message') == 'ok')
            <x-adminlte-alert class="bg-teal text-uppercase" icon="fa fa-lg fa-thumbs-up" title="Done" dismissable>
                ¡Se ha guardado con éxito!
            </x-adminlte-alert>
        @endif
        <div class="card-body">
            <form method="post" action="{{ route('cliente.store') }}">
                @csrf

                {{-- Nombre --}}
                <x-adminlte-input type="text" name="nombres" label="NOMBRE" placeholder="Example: FERNANDA"
                    label-class="text-lightblue" value="{{ old('nombres') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-user-circle text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                {{-- Email --}}
                <x-adminlte-input type="text" name="email" label="Email" placeholder="Example: info@test.com"
                    label-class="text-lightblue" value="{{ old('email') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-envelope text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                {{-- Cédula --}}
                <x-adminlte-input type="text" name="cedula" label="CÉDULA" placeholder="Example: 1718094056"
                    label-class="text-lightblue" value="{{ old('cedula') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-address-card text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                {{-- Teléfono --}}
                <x-adminlte-input type="text" name="telefono" label="TELÉFONO" placeholder="Example: 0988349826"
                    label-class="text-lightblue" value="{{ old('telefono') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-phone text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                {{-- Dirección --}}
                <x-adminlte-input type="text" name="direccion" label="DIRECCIÓN"
                    placeholder="Example: Calle las alondras" label-class="text-lightblue"
                    value="{{ old('direccion') }}">
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
