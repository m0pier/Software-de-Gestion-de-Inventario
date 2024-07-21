<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comprasmes = DB::select('
        SELECT DATE_FORMAT(c.fecha, "%Y-%m") as mes, SUM(c.total) as totalmes
        FROM compras c
        WHERE c.status = "1"
        GROUP BY DATE_FORMAT(c.fecha, "%Y-%m")
        ORDER BY DATE_FORMAT(c.fecha, "%Y-%m") DESC
        LIMIT 12
    ');

        $ventasmes = DB::select('
        SELECT DATE_FORMAT(v.fecha_venta, "%Y-%m") as mes, SUM(v.total) as totalmes
        FROM ventas v
        WHERE v.status = "1"
        GROUP BY DATE_FORMAT(v.fecha_venta, "%Y-%m")
        ORDER BY DATE_FORMAT(v.fecha_venta, "%Y-%m") DESC
        LIMIT 12
    ');

        $ventasdia = DB::select('
        SELECT DATE_FORMAT(v.fecha_venta, "%d/%m/%Y") as dia, SUM(v.total) as totaldia
        FROM ventas v
        WHERE v.status = "1"
        GROUP BY v.fecha_venta
        ORDER BY v.fecha_venta DESC
        LIMIT 15
    ');

        $totales = DB::select('
        SELECT
            (SELECT IFNULL(SUM(c.total), 0) FROM compras c WHERE DATE(c.fecha) = CURDATE() AND c.status = "1") as totalcompra,
            (SELECT IFNULL(SUM(v.total), 0) FROM ventas v WHERE DATE(v.fecha_venta) = CURDATE() AND v.status = "1") as totalventa
    ');

        $productosvendidos = DB::select('
        SELECT p.codigo as code, SUM(dv.cantidad) as cantidad, p.nombre as name, p.id, p.stock as stock
        FROM productos p
        INNER JOIN detalle_ventas dv ON p.id = dv.id_producto
        INNER JOIN ventas v ON dv.id_venta = v.id
        WHERE v.status = "1" AND YEAR(v.fecha_venta) = YEAR(CURDATE())
        GROUP BY p.codigo, p.nombre, p.id, p.stock
        ORDER BY SUM(dv.cantidad) DESC
        LIMIT 10
    ');

        return view('dashboard', compact('comprasmes', 'ventasmes', 'ventasdia', 'totales', 'productosvendidos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
