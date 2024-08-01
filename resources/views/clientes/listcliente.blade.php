@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de clientes</h1>
@stop

@section('content')
    <p>Aquí puedes visualizar la lista de clientes</p>
    <div class="card">
        <div class="card-head">
            @if (session('error') == 'ok')
                <x-adminlte-alert class="bg-danger text-uppercase" icon="fa fa-exclamation-triangle" title="Error"
                    dismissable>
                    No puedes eliminar un cliente que tenga una venta.
                </x-adminlte-alert>
            @endif
        </div>
        <div class="card-body">
            {{-- Setup data for datatables --}}
            @php
                $heads = ['ID', 'Nombre', 'Cedula', 'Email', 'Telefono', 'Dirección', ['label' => 'Actions', 'no-export' => true, 'width' => 10]];
                $btnDelete = '<button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>';
                $btnEdit = '<button type="button" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </button>';
                $config = [
                    'order' => [[1, 'asc']]
                ];
            @endphp

            {{-- Minimal example / fill data using the component slot --}}
            <x-adminlte-datatable id="table6" :heads="$heads" head-theme="light" theme="dark" :config="$config" striped
                hoverable with-footer footer-theme="light" beautify>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nombres }}</td>
                        <td>{{ $cliente->cedula }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>{{ $cliente->direccion }}</td>
                        <td>
                            <a href="{{ route('cliente.show', $cliente) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Ver">
                                <i class="fa fa-lg fa fa-eye" aria-hidden="true"></i>
                            </a>
                            <a href="{{ route('cliente.edit', $cliente) }}"
                                class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            <form style="display: inline" action="{{ route('cliente.destroy', $cliente) }}" method="POST"
                                class="formEliminar">
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
