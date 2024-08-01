@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de Proveedores</h1>
@stop

@section('content')
    <p>Aquí puedes visualizar la lista de Proveedores</p>
    <div class="card">
        <div class="card-head">
            @if (session('error') == 'No puedes eliminar un proveedor que tiene un producto habilitado.')
                <x-adminlte-alert class="bg-danger text-uppercase" icon="fa fa-exclamation-triangle" title="Error"
                    dismissable>
                    No puedes eliminar un proveedor que tenga un producto activo.
                </x-adminlte-alert>
            @endif
        </div>
        <div class="card-body">
            {{-- Setup data for datatables --}}
            @php
                $heads = [
                    'Imagen',
                    'Nombre',
                    'Ruc',
                    'Email',
                    'Telefono',
                    'Dirección',
                    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
                ];
                $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                  <i class="fa fa-lg fa-fw fa-trash"></i>
              </button>';
                $config = [];
            @endphp

            {{-- Minimal example / fill data using the component slot --}}
            <x-adminlte-datatable id="table6" :heads="$heads" head-theme="light" theme="dark" :config="$config" striped
                hoverable with-footer footer-theme="light" beautify>
                @foreach ($proveedores as $proveedor)
                    <tr>
                        <td>
                            <a href="{{ route('proveedor.show', $proveedor) }}"> <img src="{{ asset($proveedor->imagen) }}"
                                    alt="noun" class="img-thumbnail" style="width: 150px; height: 125px;"></a>
                        </td>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->ruc }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>{{ $proveedor->direccion }}</td>
                        <td>
                            <a href="{{ route('proveedor.show', $proveedor) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Ver">
                                <i class="fa fa-lg fa fa-eye" aria-hidden="true"></i>
                            </a>
                            <a href="{{ route('proveedor.edit', $proveedor) }}"
                                class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <form style="display: inline" action="{{ route('proveedor.destroy', $proveedor) }}"
                                method="POST" class="formEliminar">
                                @csrf
                                @method('delete')
                                {!! $btnDelete !!}
                            </form>
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
