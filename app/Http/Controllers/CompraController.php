<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::all();
        $detalles = DetalleCompra::all();
        return view('compras.list-compra', compact('compras', 'detalles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedors = Proveedor::all();
        $productos = Producto::where('status', '1')->get();
        return view('compras.add-compra', compact('proveedors', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $compra = Compra::create($request->all() + [
            'id_user' => Auth::user()->id,
            'fecha' => Carbon::now(),
        ]);
        foreach ($request->id_producto as $key => $producto) {
            $resultado[] = array(
                "id_producto" => $request->id_producto[$key],
                "cantidad" => $request->cantidad[$key],
                "precio" => $request->precio[$key]
            );
        }
        $compra->detallecompra()->createMany($resultado);
        return back()->with("message", "ok");
    }

    /**
     * Display the specified resource.
     */
    public function show(Compra $compra)
    {
        $subtotal = 0;
        $comprasDetalles = $compra->detallecompra;
        foreach ($comprasDetalles as $comprasDetalle) {
            $subtotal += $comprasDetalle->cantidad * $comprasDetalle->precio;
        }
        return view('compras.show-compra', compact('compra', 'subtotal', 'comprasDetalles'));
    }

    public function changeStatus(Compra $compra)
    {
        if ($compra->status == 0) {
            $compra->update(['status' => '1']);
            return back();
        } else {
            $compra->update(['status' => '0']);
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function byProveedor(Request $request)
    {
        $proveedorId = $request->input('proveedor_id');
        $productos = Producto::where('id_proveedor', $proveedorId)->get();
        return response()->json($productos);
    }

    public function pdf(Compra $compra)
    {
        $subtotal = 0;
        $comprasDetalles = $compra->detallecompra;
        foreach ($comprasDetalles as $comprasDetalle) {
            $subtotal += $comprasDetalle->cantidad * $comprasDetalle->precio;
        }

        $pdf = FacadePdf::loadView('compras.pdf-compra', compact('subtotal', 'comprasDetalles', 'compra') );
        return $pdf->download('Reporte_de_compra_'.$compra->id.'.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $compra = Compra::find($id);

        if ($compra->status == 1) {
            return back()->with('error', 'No puedes eliminar un producto que tiene stock o su estado esta activo.');
        }

        $compra->delete();

        return back();
    }
}
