@extends('adminlte::page')

@section('title', 'Información de Compra')

@section('content_header')
    <h1>Información de Compra</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h3 class="text-primary">Proveedor</h3>
                    <p class="lead">{{ $compra->proveedor->nombre }}</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <h3 class="text-primary">Número de Compra</h3>
                    <p class="lead">{{ $compra->id }}</p>
                </div>
            </div>
            <h4 class="mb-3">Detalle de Compra</h4>
            <div class="table-responsive">
                <table class="table table-striped" id="detalles">
                    <thead class="thead-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($comprasDetalles as $comprasDetalle)
                            <tr>
                                <td>{{ $comprasDetalle->producto->nombre }}</td>
                                <td>${{ number_format($comprasDetalle->precio, 2) }}</td>
                                <td>{{ $comprasDetalle->cantidad }}</td>
                                <td>${{ number_format($comprasDetalle->cantidad * $comprasDetalle->precio, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No hay detalles de compra disponibles.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">SUBTOTAL:</th>
                            <td>${{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">IVA ({{ $compra->iva }}%):</th>
                            <td>${{ number_format(($subtotal * $compra->iva) / 100, 2) }}</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">TOTAL:</th>
                            <td>${{ number_format($compra->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('compra.pdf', $compra) }}"
                                class="btn btn-success" title="Factura">
                                <i class="fa fa-lg fa-file-pdf" aria-hidden="true"></i>
                            </a>
            <a href="{{ route('compra.index') }}" class="btn btn-primary float-right">Regresar</a>
        </div>
    </div>
@stop

@section('css')
    <style>
        .table th {
            background-color: #343a40;
            color: white;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Vista de información de compra cargada");
    </script>
@stop
