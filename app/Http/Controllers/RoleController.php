<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        return view('rolesypermisos.roles', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Se puede agregar una vista para la creación de roles si es necesario.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create(['name' => $request->input('nombre')]);

        return back()->with('success', 'Rol creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Puede ser implementado si es necesario mostrar un rol específico.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permisos = Permission::all();

        return view('rolesypermisos.rolepermiso', compact('role', 'permisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permisos' => 'array',
            'permisos.*' => 'exists:permissions,id',
        ]);

        $role->permissions()->sync($request->permisos);

        return redirect()->route('roles.edit', $role)->with('success', 'Permisos actualizados exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Se puede agregar lógica para eliminar un rol.
    }
}
