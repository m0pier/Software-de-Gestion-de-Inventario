<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AsignarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('rolesypermisos.listUser', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Se puede agregar una vista para la creación de asignaciones si es necesario.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Se puede agregar lógica para almacenar asignaciones si es necesario.
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Puede ser implementado si es necesario mostrar una asignación específica.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('asignar.index')->with('error', 'Usuario no encontrado.');
        }

        $roles = Role::all();

        return view('rolesypermisos.userRol', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('asignar.index')->with('error', 'Usuario no encontrado.');
        }

        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->roles()->sync($request->roles);

        return redirect()->route('asignar.edit', $user)->with('success', 'Roles asignados exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Se puede agregar lógica para eliminar una asignación si es necesario.
    }
}
