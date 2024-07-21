@extends('adminlte::page')

@section('title', 'Reporte de ventas')

@section('content_header')
    <h1>Reporte de ventas</h1>
@stop

@section('content')
    <p>Aquí puedes visualizar el reporte de ventas por fechas</p>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Selecciona las fechas para generar el reporte</h3>
        </div>
        <div class="card-body">
            {!! Form::open(['route' => 'reporte.resultado', 'method' => 'POST']) !!}
                <div class="row justify-content-center">
                    <div class="col-12 col-md-3">
                        <div class="form-group text-center">
                            {!! Form::label('fecha_ini', 'Fecha Inicio') !!}
                            {!! Form::date('fecha_ini', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group text-center">
                            {!! Form::label('fecha_fin', 'Fecha Fin') !!}
                            {!! Form::date('fecha_fin', null, ['class' => 'form-control', 'id' => 'fecha_fin']) !!}
                        </div>
                    </div>
                    <div class="col-12 col-md-3 align-self-center">
                        <div class="form-group text-center">
                            {!! Form::submit('Consultar', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

    @if(isset($ventas))
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Resultados del reporte</h3>
            </div>
            <div class="card-body">
                <h5>Total de ventas: <strong>{{ $total }}</strong></h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Fecha de Venta</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventas as $venta)
                                <tr>
                                    <td>{{ $venta->id }}</td>
                                    <td>{{ $venta->fecha_venta }}</td>
                                    <td>{{ $venta->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@stop

@section('js')
    <script>
        window.onload = function() {
            const fecha = new Date();
            const mes = ('0' + (fecha.getMonth() + 1)).slice(-2);
            const dia = ('0' + fecha.getDate()).slice(-2);
            const ano = fecha.getFullYear();

            document.getElementById('fecha_fin').value = `${ano}-${mes}-${dia}`;
        }
    </script>
@stop
