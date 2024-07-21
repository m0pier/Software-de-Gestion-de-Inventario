@extends('adminlte::page')

@section('title', 'Agregar Producto')

@section('content_header')
    <h1>Agregar Producto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Ingresar una categoría</h2>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <x-adminlte-button label="Nueva Categoría" theme="primary" icon="fas fa-key" class="w-100"
                        data-toggle="modal" data-target="#modalCategoria" />
                </div>
            </div>
        </div>

        <div class="card-body">
            @if (session('message') == 'ok')
                <x-adminlte-alert class="bg-teal text-uppercase" icon="fa fa-lg fa-thumbs-up" title="Done" dismissable>
                    Se ha guardado con éxito!
                </x-adminlte-alert>
            @endif

            <form action="{{ route('producto.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <x-adminlte-input-file name="imagen" label="SUBIR IMAGEN" label-class="text-lightblue"
                    placeholder="Escoja la imagen" igroup-size="lg" legend="Escoja">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-primary">
                            <i class="fas fa-file-upload"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>

                <x-adminlte-input type="text" name="nombre" label="Nombre del producto" placeholder="Ex: Moladora"
                    label-class="text-lightblue" value="{{ old('nombre') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-tag"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input type="text" name="descripcion" label="Descripción"
                    placeholder="Ex: Moladora con doble rosca" label-class="text-lightblue"
                    value="{{ old('descripcion') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-align-left"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input type="text" name="codigo" label="Código" placeholder="Ex: moladoracategor654"
                    label-class="text-lightblue" value="{{ old('codigo') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-barcode" aria-hidden="true"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input type="number" name="precio" label="Precio de Venta" placeholder="54"
                    label-class="text-lightblue" value="{{ old('precio') }}">
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
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </x-adminlte-select>

                <x-adminlte-select name="id_proveedor" label="Proveedor" label-class="text-lightblue" igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-list"></i>
                        </div>
                    </x-slot>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </x-adminlte-select>

                <x-adminlte-button class="btn-flat" type="submit" label="Guardar" theme="success" icon="fas fa-save" />
            </form>
        </div>
    </div>

    <x-adminlte-modal id="modalCategoria" title="Nueva Categoría" theme="primary" icon="fas fa-bolt" size='lg'
        disable-animations>
        <form action="{{ route('categoria.store') }}" method="post">
            @csrf
            <div class="row">
                <x-adminlte-input name="nombre" label="Nombre" placeholder="Ex: Herramientas de jardín"
                    fgroup-class="col-md-6" disable-feedback />
            </div>
            <div class="row">
                <x-adminlte-input name="descripcion" label="Descripción"
                    placeholder="Ex: Perteneciente al grupo de herramientas de jardinería" fgroup-class="col-md-6"
                    disable-feedback />
            </div>
            <div class="card-body">
                @php
                    $heads = ['Nombre', 'Descripción', ['label' => 'Acciones', 'no-export' => true, 'width' => 10]];
                    // $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
//      <i class="fa fa-lg fa-fw fa-trash"></i>
// </button>';
                    $btnEdit = '<button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </button>';
                    $config = [];
                @endphp
                <x-adminlte-datatable id="table6" :heads="$heads" head-theme="light" theme="dark"
                    :config="$config" striped hoverable with-footer footer-theme="light" beautify>
                    @foreach ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ $categoria->descripcion }}</td>
                            <td>
                                <a href="{{ route('categoria.edit', $categoria) }}"
                                    class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </a>
                                <button class="btn btn-xs btn-default text-danger mx-1 shadow btn-delete"
                                    data-id="{{ $categoria->id }}"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
            <x-adminlte-button class="btn-flat" type="submit" label="Guardar" theme="success"
                icon="fas fa-lg fa-save" />
        </form>
    </x-adminlte-modal>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    if (confirm('¿Estás seguro de que deseas eliminar esta categoría?')) {
                        let categoryId = this.getAttribute('data-id');

                        fetch(`/categoria/${categoryId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    location.reload();
                                } else {
                                    alert('Hubo un error al eliminar la categoría.');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            });
        });
    </script>
@stop
