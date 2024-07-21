@extends('adminlte::page')

@section('title', 'Información de venta')

@section('content_header')
    <h1 class="m-0 text-dark">Información de venta</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <h5 class="mb-3">Cliente:</h5>
                        <h3 class="text-dark mb-1">{{ $venta->cliente->nombres }}</h3>
                    </div>
                    <div class="col-sm-4">
                        <h5 class="mb-3">Vendedor:</h5>
                        <h3 class="text-dark mb-1">{{ $venta->user->name }}</h3>
                    </div>
                    <div class="col-sm-4">
                        <h5 class="mb-3">Número de venta:</h5>
                        <h3 class="text-dark mb-1">#{{ $venta->id }}</h3>
                    </div>
                </div>

                <h4 class="mt-4 mb-3">Detalle de venta</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Descuento</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ventasDetalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->producto->nombre }}</td>
                                    <td>${{ number_format($detalle->precio, 2) }}</td>
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td>{{ $detalle->descuento }}%</td>
                                    <td>${{ number_format($detalle->cantidad * $detalle->precio * (1 - $detalle->descuento / 100), 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay detalles de venta disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <table class="table table-sm">
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>${{ number_format($subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <th>IVA ({{ $venta->iva }}%):</th>
                                <td>${{ number_format($iva, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>${{ number_format($subtotal + $iva, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('venta.pdf', $venta->id) }}"
                                class="btn btn-success" title="Factura">
                                <i class="fa fa-lg fa-file-pdf" aria-hidden="true"></i>
                            </a>
                <a href="{{ route('venta.index') }}" class="btn btn-primary float-right">Regresar</a>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .table thead th {
        border-top: none;
        border-bottom: 2px solid #dee2e6;
    }
    .table-sm th, .table-sm td {
        padding: 0.3rem;
    }
</style>
@stop

@section('js')
<script>
    console.log("Vista de información de venta cargada");
</script>
@stop
