@extends('adminlte::page')

@section('title', 'Agregar Venta')

@section('content_header')
    <h1>Agregar una venta</h1>
@stop

@section('content')
    <div class="card">
        @if (session('message') == 'ok')
            <x-adminlte-alert class="bg-teal text-uppercase" icon="fa fa-lg fa-thumbs-up" title="Done" dismissable>
                ¡Se ha guardado con éxito!
            </x-adminlte-alert>
        @endif
        <div class="card-body">
            <form method="post" action="{{ route('venta.store') }}">
                @csrf
                <x-adminlte-select2 name="id_cliente" label="Cliente" label-class="text-lightblue" igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-user"></i>
                        </div>
                    </x-slot>
                    @foreach ($clients as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombres }} - {{ $cliente->cedula }}</option>
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-select2 name="id_producto" label="Producto" label-class="text-lightblue" igroup-size="lg" id="id_producto">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-box"></i>
                        </div>
                    </x-slot>
                    <option value="">Seleccione un producto</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}_{{ $producto->stock }}_{{ $producto->precio }}">Nombre:{{ $producto->nombre }} - Cat:{{ $producto->categoria->nombre }}</option>
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-input type="number" name="stock" label="Stock actual" label-class="text-lightblue" id="stock" readonly>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-boxes text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-select name="iva" label="IVA (%)" label-class="text-lightblue" igroup-size="lg" id="iva">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-percent"></i>
                        </div>
                    </x-slot>
                    <option value="15">15</option>
                </x-adminlte-select>

                <x-adminlte-input type="number" name="cantidad" label="Cantidad" placeholder="Ej: 10" label-class="text-lightblue" id="cantidad">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-hashtag text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input type="number" step="0.01" name="precio" label="Precio" label-class="text-lightblue" id="precio" readonly>
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-dollar-sign text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <x-adminlte-input type="number" name="descuento" label="Porcentaje de descuento" placeholder="Ej: 13" label-class="text-lightblue" id="descuento" value="0">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-percentage text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>

                <div class="form-group">
                    <button type="button" class="btn btn-primary float-right" id="agregar">Agregar producto</button>
                </div>

                <div class="form-group">
                    <h4 class="card-title">Detalles de venta</h4>
                    <div class="table-responsive col-md-12">
                        <table class="table table-striped" id="detalles">
                            <thead>
                                <tr>
                                    <th>Eliminar</th>
                                    <th>Producto</th>
                                    <th>Precio de Venta</th>
                                    <th>Descuento</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-right">TOTAL:</th>
                                    <th><span id="total">$ 0.00</span></th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-right">TOTAL IMPUESTO:</th>
                                    <th><span id="total_impuesto">$ 0.00</span></th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-right">TOTAL A PAGAR:</th>
                                    <th>
                                        <span id="total_pagar_html">$ 0.00</span>
                                        <input type="hidden" name="total" id="total_pagar">
                                    </th>
                                </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <x-adminlte-button class="btn-flat" id="guardar" type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save" />
                <a href="{{ route('venta.index') }}" class="btn btn-danger">Cancelar</a>
            </form>
        </div>
    </div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $("#agregar").click(function() {
            agregar();
        });
    });

    var cont = 0;
    var total = 0;
    var subtotal = [];
    var impuesto = 15;

    $("#guardar").hide();
    $("#id_producto").change(mostrarValores);

    function mostrarValores() {
        datosProducto = document.getElementById('id_producto').value.split('_');
        $("#precio").val(datosProducto[2]);
        $("#stock").val(datosProducto[1]);
    }

    function agregar() {
        datosProducto = document.getElementById('id_producto').value.split('_');

        id_producto = datosProducto[0];
        producto = $("#id_producto option:selected").text();
        cantidad = $("#cantidad").val();
        descuento = $("#descuento").val();
        precio = $("#precio").val();
        stock = $("#stock").val();
        impuesto = $("#iva").val();

        if (id_producto != "" && cantidad != "" && cantidad > 0 && descuento != "" && precio != "") {
            if (parseInt(stock) >= parseInt(cantidad)) {
                subtotal[cont] = (cantidad * precio) - (cantidad * precio * descuento / 100);
                total = total + subtotal[cont];
                var fila = '<tr class="selected" id="fila' + cont + '">' +
                    '<td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar(' + cont + ');"><i class="fa fa-times"></i></button></td>' +
                    '<td><input type="hidden" name="id_producto[]" value="' + id_producto + '">' + producto + '</td>' +
                    '<td><input type="hidden" name="precio[]" value="' + parseFloat(precio).toFixed(2) + '"><input type="number" class="form-control" value="' + parseFloat(precio).toFixed(2) + '" disabled></td>' +
                    '<td><input type="hidden" name="descuento[]" value="' + parseFloat(descuento) + '"><input type="number" class="form-control" value="' + parseFloat(descuento) + '" disabled></td>' +
                    '<td><input type="hidden" name="cantidad[]" value="' + cantidad + '"><input type="number" value="' + cantidad + '" class="form-control" disabled></td>' +
                    '<td align="right">$' + parseFloat(subtotal[cont]).toFixed(2) + '</td>' +
                    '</tr>';
                cont++;
                limpiar();
                totales();
                evaluar();
                $('#detalles').append(fila);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'La cantidad a vender supera el stock.',
                })
            }
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Rellene todos los campos del detalle de la venta.",
            });
        }
    }

    function limpiar() {
        $("#cantidad").val("");
        $("#descuento").val("0");
        $("#precio").val("");
    }

    function totales() {
        $("#total").html('$ ' + total.toFixed(2));
        total_impuesto = total * impuesto / 100;
        total_pagar = total + total_impuesto;
        $("#total_impuesto").html('$ ' + total_impuesto.toFixed(2));
        $("#total_pagar_html").html('$ ' + total_pagar.toFixed(2));
        $("#total_pagar").val(total_pagar.toFixed(2));
    }

    function evaluar() {
        if (total > 0) {
            $("#guardar").show();
        } else {
            $("#guardar").hide();
        }
    }

    function eliminar(index) {
        total = total - subtotal[index];
        total_impuesto = total * impuesto / 100;
        total_pagar = total + total_impuesto;
        $("#total").html("$ " + total.toFixed(2));
        $("#total_impuesto").html("$ " + total_impuesto.toFixed(2));
        $("#total_pagar_html").html("$ " + total_pagar.toFixed(2));
        $("#total_pagar").val(total_pagar.toFixed(2));
        $("#fila" + index).remove();
        evaluar();
    }
</script>
@stop
