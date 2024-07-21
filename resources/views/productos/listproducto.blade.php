@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Productos</h1>
@stop

@section('content')
    <p>Aquí puedes visualizar la lista de Proveedores</p>
    <div class="card">
        <div class="card-head">
            @if (session('error') == 'No puedes eliminar un producto que tiene stock o su estado esta activo.')
                <x-adminlte-alert class="bg-danger text-uppercase" icon="fa fa-exclamation-triangle" title="Error"
                    dismissable>
                    No puedes eliminar un producto que tiene stock o su estado esta activo.
                </x-adminlte-alert>
            @endif
        </div>
        <div class="card-body">
            {{-- Setup data for datatables --}}
            @php
                $heads = [
                    'Imagen',
                    'Nombre',
                    'Categoria',
                    'Proveedor',
                    'Codigo',
                    'Descripcion',
                    'Precio',
                    'Stock',
                    'Estado',
                    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                ];
                $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
              <i class="fa fa-lg fa-fw fa-trash"></i>
          </button>';
                $btnEdit = '<button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </button>';
                $config = [];
            @endphp

            {{-- Minimal example / fill data using the component slot --}}
            <x-adminlte-datatable id="table6" :heads="$heads" head-theme="light" theme="dark" :config="$config" striped
                hoverable with-footer footer-theme="light" beautify>
                @foreach ($productos as $producto)
                    <tr>
                        <td>
                            <a href="{{ route('producto.show', $producto) }}"> <img src="{{ asset($producto->imagen) }}"
                                    alt="noun" class="img-thumbnail" style="width: 150px; height: 125px;"></a>
                        </td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->categoria->nombre }}</td>
                        <td>{{ $producto->proveedor->nombre }}</td>
                        <td>{{ $producto->codigo }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td>
                            @can('Borrar productos')
                                @if ($producto->status == 1)
                                    <a href="{{ route('productstatus', $producto) }}" class="nav-link"> <span
                                            class="btn btn-success">Activo</span></a>
                                @else
                                    <a href="{{ route('productstatus', $producto) }}" class="nav-link"> <span
                                            class="btn btn-danger">Desactivado</span></a>
                                @endif
                            @endcan
                        </td>
                        <td>
                            <a href="{{ route('producto.show', $producto) }}"
                                class="btn btn-xs btn-default text-primary mx-1 shadow" title="Ver">
                                <i class="fa fa-lg fa fa-eye" aria-hidden="true"></i>
                            </a>
                            @can('Borrar productos')
                                <a href="{{ route('producto.edit', $producto) }}"
                                    class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                    <i class="fa fa-lg fa-fw fa-pen"></i>
                                </a>
                            @endcan
                            @can('Borrar productos')
                                <form style="display: inline" action="{{ route('producto.destroy', $producto) }}"
                                    method="POST" class="formEliminar">
                                    @csrf
                                    @method('delete')
                                    {!! $btnDelete !!}
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.formEliminar');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "¿Estás seguro?",
                        text: "Se va a eliminar un registro.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, eliminar registro."
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@stop
