<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <link rel="stylesheet" href="factura/css/main.css">
</head>

<body>
    <div class="control-bar">
        <div class="container">
            <div class="row">
                <div class="col-2-4">
                    <div class="slogan">Facturación</div>

                    <label for="config_tax">IVA:
                        {{ $venta->iva }}
                    </label>
                    <label for="config_note">Nota:
                        {{ $venta->id }}
                    </label>

                </div>
            </div><!--.row-->
        </div><!--.container-->
    </div><!--.control-bar-->

    <header class="row">
        <div class="me">
            <p contenteditable>
                <strong>Sistema de control Ferro Market S.A</strong><br>
                Quito, El valle<br>
                Ecuador<br>

            </p>
        </div><!--.me-->

        <div class="info">
            <p contenteditable>
                Web: <a href="">www.ferromarket.com</a><br>
                E-mail: <a href="">info@ferromarket.com</a><br>
                Tel: +593 0988349725<br>
                Twitter: @ferromarket
            </p>
        </div><!-- .info -->

    </header>


    <div class="row section">

        <div class="col-2">
            <h1 contenteditable>Factura</h1>
        </div><!--.col-->

        <div class="col-2 text-right details">
            <p contenteditable>
                Fecha: {{ $venta->fecha_venta }}
                Factura #: {{ $venta->id }}
            </p>
        </div><!--.col-->



        <div class="col-2">


            <p contenteditable class="client">
                <strong>Facturar a</strong><br>
                {{ $venta->cliente->nombres }}<br>
                {{ $venta->cliente->cedula }}<br>
                {{ $venta->cliente->email }}<br>
                +593 {{ $venta->cliente->telefono }}
                {{ $venta->cliente->direccion }}
            </p>
        </div><!--.col-->



    </div><!--.row-->

    <div class="row section" style="margin-top:-1rem">
        <div class="col-1">
            <table style='width:100%'>
                <thead contenteditable>
                    <tr class="invoice_detail">
                        <th width="30%" style="text-align">Vendedor</th>
                        <th width="30%">Orden de venta </th>
                        <th width="30%">Términos y condiciones</th>
                    </tr>
                </thead>
                <tbody contenteditable>
                    <tr class="invoice_detail">
                        <td width="30%" style="text-align">{{ $venta->user->name }}</td>
                        <td width="30%">#Ferromarket-vent0{{ $venta->id }} </td>
                        <td width="30%">Pago al contado</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div><!--.row-->

    <div class="invoicelist-body">
        <table>
            <thead contenteditable>
                <th width="5%">Código</th>
                <th width="50%">Descripción</th>
                <th width="10%">Cant.</th>
                <th width="10">%Descuento</th>
                <th width="25%">Precio</th>
                <th width="25%">Total</th>
            </thead>

            <tbody>
                @foreach ($ventasDetalles as $detalles)
                    <tr>
                        <td width='5%'><a class="control removeRow" href="#">x</a> <span
                                contenteditable>{{ $detalles->producto->codigo }}</span></td>
                        <td width='60%'><span contenteditable>{{ $detalles->producto->nombre }}--{{ $detalles->producto->descripcion }}</span></td>
                        <td class="amount" width='10%'><input type="text"
                                 />{{ $detalles->cantidad }}</td>
                        <td class="amount" width='10%'><input type="text"
                                 />%{{ $detalles->descuento }}</td>
                        <td class="rate" width='25%'><input type="text"
                                 />{{ $detalles->precio }}</td>
                        <td class="sum" width='25%'>{{ number_format($detalles->cantidad * $detalles->precio * (1 - $detalles->descuento / 100), 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div><!--.invoice-body-->

    <div class="invoicelist-footer">
        <table contenteditable>
            <tr class="taxrelated">
                <td>Subtotal:</td>
                <td id="total_tax">{{ number_format($subtotal,2) }}</td>
            </tr>
            <tr class="taxrelated">
                <td>IVA({{ $venta->iva }}):</td>
                <td id="total_tax">{{ number_format($iva, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total:</strong></td>
                <td id="total_price">{{ number_format($subtotal+$iva,2) }}</td>
            </tr>
        </table>
    </div>

    <div class="note" contenteditable>
        <h2>Nota:</h2>
      </div><!--.note-->

      <footer class="row">
        <div class="col-1 text-center">
          <p class="notaxrelated" contenteditable>El monto de la Factura ya incluye el impuesto de cada producto.</p>

        </div>
      </footer>


    <script src="factura/js/main.js"></script>
</body>

</html>
