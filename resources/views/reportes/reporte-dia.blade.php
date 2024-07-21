@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Reporte de ventas</h1>
@stop

@section('content')
    <p>Aquí puedes visualizar el reporte de ventas por dia</p>
    <div class="card">
        <div class="row">
            <div class="col-12 col-md-4 text-center">
                <span>Fecha de consulta: <b></b></span>
                <div class="form-group">
                    <strong>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</strong>
                </div>
            </div>
            <div class="col-12 col-md-4 text-center">
                <span>Cantidad de registros: <b></b></span>
                <div class="form-group">
                    <strong>{{ $ventas->count()}}</strong>
                </div>
            </div>
            <div class="col-12 col-md-4 text-center">
                <span>Total de ingresos: <b></b></span>
                <div class="form-group">
                    <strong>${{ $total }}</strong>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{-- Setup data for datatables --}}
            @php
                $heads = [
                    'ID',
                    'Vendedor',
                    'fecha',
                    'total',
                ];
                $config = [];
            @endphp

            {{-- Minimal example / fill data using the component slot --}}
            <x-adminlte-datatable id="table6" :heads="$heads" head-theme="light" theme="dark" :config="$config" striped
                hoverable with-footer footer-theme="light" beautify>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->user->name }}</td>
                        <td>{{ $venta->fecha_venta }}</td>
                        <td>${{ $venta->total }}</td>
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
@stop
