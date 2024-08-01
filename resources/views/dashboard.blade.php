@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    @can('Ver estadisticas')
        <div class="row justify-content-evenly">
            <div class="col-4 ">
                <x-adminlte-small-box title="Total Compras Hoy" text="{{ $totales[0]->totalcompra }}" icon="fas fa-shopping-cart"
                    theme="info" class="small-box-custom" />
            </div>
            <div class="col-4">
                <x-adminlte-small-box title="Total Ventas Hoy" text="{{ $totales[0]->totalventa }}" icon="fas fa-cash-register"
                    theme="success" class="small-box-custom" />
            </div>
        </div>

        <div class="row justify-content-evenly">
            <div class="col-12">
                <h2>Compras del Mes</h2>
            </div>
            @foreach ($comprasmes as $compra)
                <div class="col-4 ">
                    <x-adminlte-small-box title="Compras en {{ $compra->mes }}" text="{{ $compra->totalmes }}"
                        icon="fas fa-shopping-bag" theme="primary" class="small-box-custom" />
                </div>
            @endforeach
        </div>

        <div class="row justify-content-evenly">
            <div class="col-12">
                <h2>Ventas del Mes</h2>
            </div>
            @foreach ($ventasmes as $venta)
                <div class="col-4 ">
                    <x-adminlte-small-box title="Ventas en {{ $venta->mes }}" text="{{ $venta->totalmes }}"
                        icon="fas fa-chart-line" theme="warning" class="small-box-custom" />
                </div>
            @endforeach
        </div>

        <div class="row justify-content-evenly">
            <div class="col-12">
                <h2>Ventas del Día</h2>
            </div>
            @foreach ($ventasdia as $venta)
                <div class="col-4 ">
                    <x-adminlte-small-box title="Ventas el {{ $venta->dia }}" text="{{ $venta->totaldia }}"
                        icon="fas fa-calendar-day" theme="danger" class="small-box-custom" />
                </div>
            @endforeach
        </div>

        <div class="row justify-content-evenly">
            <div class="col-12">
                <h2>Productos Más Vendidos</h2>
            </div>
            @foreach ($productosvendidos as $producto)
                <div class="col-4">
                    <x-adminlte-small-box title="{{ $producto->name }}" text="Cantidad Vendida: {{ $producto->cantidad }}"
                        icon="fas fa-box-open" theme="teal" class="small-box-custom" />
                </div>
            @endforeach
        </div>
    @endcan
@stop

@section('css')
    <style>
        .small-box-custom {
            min-width: 350px;
            min-height: 150px;
            font-size: 2em;
        }

        .small-box-custom .small-box-footer {
            font-size: 0.9em;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
