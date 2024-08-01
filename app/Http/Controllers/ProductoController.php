<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        return view('productos.listproducto', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('productos.addproducto', compact('categorias', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validacion = $request->validate([
            'nombre' => 'required|string|max:80',
            'codigo' => 'required|string|min:7|max:20|unique:productos,codigo',
            'descripcion' => 'required|string|max:200',
            'precio' => 'required',
            'imagen' => 'required',
        ]);

        $producto = new Producto();
        $producto->nombre = $request->input('nombre');
        $producto->codigo = $request->input('codigo');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio = $request->input('precio');
        $producto->id_proveedor = $request->input('id_proveedor');
        $producto->id_categoria = $request->input('id_categoria');
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $destinationPath = 'images/imagen/';
            $filename = time() . '-' . $file->getClientOriginalName();
            $uploadSuccess = $request->file('imagen')->move($destinationPath, $filename);
            $producto->imagen = $destinationPath . $filename;
        }
        $producto->save();
        return back()->with('message', 'ok');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $categoria = $producto->categoria;
        $productos = Producto::where('id_categoria', $categoria->id)->get();
        return view('productos.showproducto', compact('productos', 'categoria', 'producto'));
    }


    public function changeStatus(Producto $producto)
    {
        if ($producto->status == 0) {
            $producto->update(['status' => '1']);
            return back();
        } else {
            $producto->update(['status' => '0']);
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = Producto::find($id);
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('productos.editproducto', compact('producto', 'proveedores', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validacion = $request->validate([
            'nombre' => 'required|string|max:80',
            'codigo' => 'required|string|min:7|max:20',
            'descripcion' => 'required|string|max:200',
            'precio' => 'required',
        ]);

        $producto = Producto::find($id);
        $producto->nombre = $request->input('nombre');
        $producto->codigo = $request->input('codigo');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio = $request->input('precio');
        $producto->id_proveedor = $request->input('id_proveedor');
        $producto->id_categoria = $request->input('id_categoria');

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');

            // Validar que es una imagen válida
            $request->validate([
                'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $destinationPath = 'images/imagen/';
            $filename = time() . '-' . $file->getClientOriginalName();

            // Verificar si la carga fue exitosa
            if ($file->move($destinationPath, $filename)) {
                // Eliminar la imagen anterior
                if ($producto->imagen) {
                    Storage::delete($producto->imagen);
                }
                // Actualizar el campo imagen
                $producto->imagen = $destinationPath . $filename;
            } else {
                Log::error('La carga de la imagen falló. Ruta destino: ' . $destinationPath);
            }
        }
        $producto->save();
        return back()->with('message', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::find($id);

        // Verificar si el producto tiene stock
        if ($producto->stock >= 1 && $producto->status == 1) {
            return back()->with('error', 'No puedes eliminar un producto que tiene stock o su estado esta activo.');
        }

        $producto->delete();

        return back();
    }
}
