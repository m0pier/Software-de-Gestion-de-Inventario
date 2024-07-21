@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Agregar una compra</h1>
@stop

@section('content')
    <p>Ingrese una compra</p>
    <div class="card">
        @if (session('message') == 'ok')
            <x-adminlte-alert class="bg-teal text-uppercase" icon="fa fa-lg fa-thumbs-up" title="Done" dismissable>
                ¡Se ha guardado con éxito!
            </x-adminlte-alert>
        @endif
        <div class="card-body">
            <form method="post" action="{{ route('compra.store') }}">
                @csrf
                {{-- Proveedor --}}
                <x-adminlte-select2 name="id_proveedor" id="id_proveedor" label="Proveedor" label-class="text-lightblue"
                    igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-list"></i>
                        </div>
                    </x-slot>
                    <option value="">Selecciona un proveedor</option>
                    @foreach ($proveedors as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }} - {{ $proveedor->ruc }}</option>
                    @endforeach
                </x-adminlte-select2>
                {{-- Producto --}}
                <x-adminlte-select2 name="id_producto" id="id_producto" label="Producto" label-class="text-lightblue"
                    igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-list"></i>
                        </div>
                    </x-slot>
                    <option value="">Selecciona un proveedor primero</option>
                </x-adminlte-select2>
                {{-- Iva --}}
                <x-adminlte-select name="iva" label="Iva" label-class="text-lightblue" igroup-size="lg">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-info">
                            <i class="fas fa-list"></i>
                        </div>
                    </x-slot>
                    <option value="12">12</option>
                    <option value="15">15</option>
                </x-adminlte-select>
                {{-- Cantidad --}}
                <x-adminlte-input type="number" name="cantidad" label="Cantidad" placeholder="Ex: 10"
                    label-class="text-lightblue" value="{{ old('cantidad') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-cube text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                {{-- Precio --}}
                <x-adminlte-input type="number" step="0.01" name="precio" label="Precio" placeholder="Ex: 15.99"
                    label-class="text-lightblue" value="{{ old('precio') }}">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fa fa-dollar-sign text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <div class="form-group">
                    <button type="button" class="btn btn-primary float-right" id="agregar">Agregar producto</button>
                </div>
                <div class="form-group">
                    <h4 class="card-title">Detalles de compra</h4>
                    <div class="table-responsive col-md-12">
                        <table class="table table-striped" id="detalles">
                            <thead>
                                <tr>
                                    <th>Eliminar</th>
                                    <th>Producto</th>
                                    <th>Precio </th>
                                    <th>Cantidad</th>
                                    <th>Subtotal </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="4">
                                        <p align="right">TOTAL:</p>
                                    </th>
                                    <th>
                                        <p align="right"><span id="total"> 0.00</span></p>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4">
                                        <p align="right">TOTAL IMPUESTO (%):</p>
                                    </th>
                                    <th>
                                        <p align="right"><span id="total_impuesto"> 0.00</span></p>
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4">
                                        <p align="right">TOTAL PAGAR:</p>
                                    </th>
                                    <th>
                                        <p align="right"><span id="total_pagar_html"> 0.00</span><input type="hidden"
                                                name="total" id="total_pagar"></p>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                {{-- Botón --}}
                <x-adminlte-button class="btn-flat" id="guardar" type="submit" label="Guardar" theme="success"
                    icon="fas fa-lg fa-save" />
                <a href="{{ route('compra.index') }}" class="btn btn-danger"> Cancelar</a>
            </form>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

    <script>
        $(document).ready(function() {
            $('#id_proveedor').change(function() {
                var proveedorId = $(this).val();
                var productoSelect = $('#id_producto');

                // Limpiar opciones anteriores
                productoSelect.empty();
                productoSelect.append('<option value="">Cargando...</option>');

                if (proveedorId) {
                    $.ajax({
                        url: '{{ route('compras.byProveedor') }}',
                        method: 'GET',
                        data: {
                            proveedor_id: proveedorId
                        },
                        success: function(data) {
                            productoSelect.empty();
                            productoSelect.append(
                                '<option value="">Selecciona un producto</option>');

                            data.forEach(function(producto) {
                                productoSelect.append(
                                    `<option value="${producto.id}">${producto.nombre}</option>`
                                );
                            });
                        },
                        error: function() {
                            productoSelect.empty();
                            productoSelect.append(
                                '<option value="">Error al cargar productos</option>');
                        }
                    });
                } else {
                    productoSelect.empty();
                    productoSelect.append('<option value="">Selecciona un proveedor primero</option>');
                }
            });
        });
    </script>

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

        function agregar() {
            var id_producto = $("#id_producto").val();
            var producto = $("#id_producto option:selected").text();
            var cantidad = $("#cantidad").val();
            var precio = $("#precio").val();

            if (id_producto != "" && cantidad != "" && cantidad > 0 && precio != "") {
                subtotal[cont] = cantidad * precio;
                total = total + subtotal[cont];
                var fila = '<tr class="selected" id="fila' + cont + '">' +
                    '<td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar(' + cont + ');">' +
                    '<i class="fa fa-times"></i></button></td>' +
                    '<td><input type="hidden" name="id_producto[]" value="' + id_producto + '">' + producto + '</td>' +
                    '<td><input type="hidden" id="precio[]" name="precio[]" value="' + precio + '">' +
                    '<input class="form-control" type="number" value="' + precio + '" disabled></td>' +
                    '<td><input type="hidden" name="cantidad[]" value="' + cantidad + '">' +
                    '<input class="form-control" type="number" value="' + cantidad + '" disabled></td>' +
                    '<td align="right">$' + subtotal[cont].toFixed(2) + '</td></tr>';
                cont++;
                limpiar();
                totales();
                evaluar();
                $('#detalles').append(fila);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Rellene todos los campos de la venta!",
                    footer: '<a href="{{ route('compra.create') }}">Ingrese nuevamente</a>'
                });
            }
        }

        function limpiar() {
            $("#cantidad").val("");
            $("#precio").val("");
        }

        function totales() {
            $("#total").html('$' + total.toFixed(2));
            var total_impuesto = total * impuesto / 100;
            var total_pagar = total + total_impuesto;
            $("#total_impuesto").html('$' + total_impuesto.toFixed(2));
            $("#total_pagar_html").html('$' + total_pagar.toFixed(2));
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
            var total_impuesto = total * impuesto / 100;
            var total_pagar_html = total + total_impuesto;
            $("#total").html("$" + total.toFixed(2));
            $("#total_impuesto").html("$ " + total_impuesto.toFixed(2));
            $("#total_pagar_html").html("$ " + total_pagar_html.toFixed(2));
            $("#total_pagar").val(total_pagar_html.toFixed(2));
            $("#fila" + index).remove();
            evaluar();
        }
    </script>
@stop
