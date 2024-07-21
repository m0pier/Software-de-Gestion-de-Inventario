<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permisos = Permission::all();

        return view('rolesypermisos.permisos', compact('permisos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Se puede agregar una vista para la creación de permisos si es necesario.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->input('nombre')]);

        return back()->with('success', 'Permiso creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Puede ser implementado si es necesario mostrar un permiso específico.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Puede ser implementado si es necesario mostrar un formulario para editar permisos.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Puede ser implementado si es necesario actualizar permisos.
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Puede ser implementado si es necesario eliminar un permiso.
    }
}
