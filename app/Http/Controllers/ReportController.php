<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function reporte_dia()
    {
        $ventas = Venta::whereDate('fecha_venta', Carbon::today())->get();
        $total = $ventas->sum('total');
        return view('reportes.reporte-dia', compact('ventas', 'total'));
    }
    public function reporte_fecha()
    {
        $ventas = Venta::whereDate('fecha_venta', Carbon::today())->get();
        $total = $ventas->sum('total');
        return view('reportes.reporte-fecha', compact('ventas', 'total'));
    }

    public function reporte_resultado(Request $request)
    {
        // Validar que las fechas estén presentes
        $request->validate([
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        // Obtener las fechas y añadir horas para el rango
        $fi = $request->input('fecha_ini') . ' 00:00:00';
        $ff = $request->input('fecha_fin') . ' 23:59:59';

        // Obtener las ventas dentro del rango de fechas
        $ventas = Venta::whereBetween('fecha_venta', [$fi, $ff])->get();

        // Depurar las ventas para verificar que se obtienen correctamente
        // dd($ventas);

        // Calcular el total de las ventas
        $total = $ventas->sum('total');

        // Retornar la vista con los datos
        return view('reportes.reporte-fecha', compact('ventas', 'total'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
