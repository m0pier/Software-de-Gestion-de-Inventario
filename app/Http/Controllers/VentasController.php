<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use App\Notifications\StockNotification;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::all();
        $detalles = DetalleVenta::all();
        return view('ventas.list-venta', compact('ventas', 'detalles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Cliente::all();
        $productos = Producto::where('status', '1')->get();

        $admin = User::role('Administrador')->first();

        foreach ($productos as $producto) {
            // Verificar si el stock es menor o igual a 10
            if ($producto->stock <= 10 && !$producto->notificacion_enviada) {
                if ($admin) {
                    $admin->notify(new StockNotification($producto));
                }

                // Marcar la notificación como enviada
                $producto->notificacion_enviada = true;
                $producto->save();
            }

            // Verificar si el stock se ha rellenado
            if ($producto->stock > 10 && $producto->notificacion_enviada) {
                // Restablecer el estado de la notificación
                $producto->notificacion_enviada = false;
                $producto->save();
            }
        }

        return view('ventas.add-venta', compact('clients', 'productos'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $venta = Venta::create($request->all() + [
            'id_user' => Auth::user()->id,
            'fecha_venta' => Carbon::now(),
        ]);
        foreach ($request->id_producto as $key => $producto) {
            $resultado[] = array(
                "id_producto" => $request->id_producto[$key],
                "cantidad" => $request->cantidad[$key],
                "precio" => $request->precio[$key],
                "descuento" => $request->descuento[$key]
            );
        }
        $venta->DetalleVentas()->createMany($resultado);
        return back()->with("message", "ok");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $venta = Venta::findOrFail($id);
        $subtotal = 0;
        $ventasDetalles = $venta->DetalleVentas;
        foreach ($ventasDetalles as $detalle) {
            $subtotal += $detalle->cantidad * $detalle->precio * (1 - $detalle->descuento / 100);
        }
        $iva = $subtotal * $venta->iva / 100;
        return view('ventas.show-venta', compact('venta', 'subtotal', 'iva', 'ventasDetalles'));
    }


    public function changeStatus(Venta $venta)
    {
        if ($venta->status == 0) {
            $venta->update(['status' => '1']);
            return back();
        } else {
            $venta->update(['status' => '0']);
            return back();
        }
    }

    public function pdf($id)
    {
        $venta = Venta::findOrFail($id);
        $subtotal = 0;
        $ventasDetalles = $venta->DetalleVentas;
        foreach ($ventasDetalles as $detalle) {
            $subtotal += $detalle->cantidad * $detalle->precio * (1 - $detalle->descuento / 100);
        }
        $iva = $subtotal * $venta->iva / 100;

        $pdf = FacadePdf::loadView('ventas.pdf-venta', compact('venta', 'subtotal', 'iva', 'ventasDetalles'));

        return $pdf->download('Factura_de_venta_' . $id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $venta = Venta::find($id);

        if ($venta->status == 1) {
            return back()->with('error', 'No puedes eliminar un producto que tiene stock o su estado esta activo.');
        }

        $venta->delete();

        return back();
    }
}
