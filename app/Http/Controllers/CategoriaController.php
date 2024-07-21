<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{

    public function index()
    {
    }


    public function create()
    {
    }


    public function store(Request $request)
    {
        $validacion = $request->validate([
            'nombre' => 'required|string|max:25',
            'descripcion' => 'required|string|max:80'
        ]);

        $categoria = new Categoria();

        $categoria->nombre = $request->nombre;

        $categoria->descripcion = $request->descripcion;

        $categoria->save();

        return back()->with('message', 'ok');
    }


    public function show(string $id)
    {
    }


    public function edit(string $id)
    {
        $categoria = Categoria::find($id);
        return view('productos.edit-categoria', compact('categoria'));
    }


    public function update(Request $request, string $id)
    {
        $validacion = $request->validate([
            'nombre' => 'required|string|max:25',
            'descripcion' => 'required|string|max:80'
        ]);

        $categoria = Categoria::find($id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();
        return back()->with('message', 'ok');
    }


    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->producto()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'No se puede eliminar una categoría asignada a un producto.']);
        }

        if ($categoria->delete()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
