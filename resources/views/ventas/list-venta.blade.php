@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de ventas</h1>
@stop

@section('content')
    <p>Aquí puedes visualizar la lista de Ventas</p>
    <div class="card">
        <div class="card-head">
            @if (session('error') == 'No puedes eliminar un producto que tiene stock o su estado esta activo.')
                <x-adminlte-alert class="bg-danger text-uppercase" icon="fa fa-exclamation-triangle" title="Error"
                    dismissable>
                    No puedes eliminar un producto que su estado este activo.
                </x-adminlte-alert>
            @endif
        </div>
        <div class="card-body">
            {{-- Setup data for datatables --}}
            @php
                $heads = [
                    'ID',
                    'Cliente',
                    'Vendedor',
                    'fecha',
                    'iva',
                    'total',
                    'status',
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
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->cliente->nombres }}</td>
                        <td>{{ $venta->user->name }}</td>
                        <td>{{ $venta->fecha_venta }}</td>
                        <td>%{{ $venta->iva }}</td>
                        <td>${{ $venta->total }}</td>
                        <td>
                            @can('Borrar ventas')
                                @if ($venta->status == 1)
                                    <a href="{{ route('ventastatus', $venta) }}" class="nav-link"> <span
                                            class="btn btn-success">Activo</span></a>
                                @else
                                    <a href="{{ route('ventastatus', $venta) }}" class="nav-link"> <span
                                            class="btn btn-danger">Cancelado</span></a>
                                @endif
                            @endcan
                        </td>
                        <td>
                            <a href="{{ route('venta.show', $venta->id) }}"
                                class="btn btn-xs btn-default text-primary mx-1 shadow" title="Ver">
                                <i class="fa fa-lg fa fa-eye" aria-hidden="true"></i>
                            </a>
                            <a href="{{ route('venta.pdf', $venta->id) }}"
                                class="btn btn-xs btn-default text-primary mx-1 shadow" title="Factura">
                                <i class="fa fa-lg fa-file-pdf" aria-hidden="true"></i>
                            </a>
                            @can('Borrar ventas')
                                <form style="display: inline" action="{{ route('venta.destroy', $venta) }}" method="POST"
                                    class="formEliminar">
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
