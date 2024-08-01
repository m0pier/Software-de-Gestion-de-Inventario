<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.listproveedor', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proveedores.addproveedor');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validacion = $request->validate([
            'imagen'=>'required|image',
            'nombre'=> 'required|max:80',
            'ruc'=> 'required|string|min:13|unique:proveedors,ruc',
            'email'=> 'required|string|max:100|unique:proveedors,email',
            'telefono'=> 'required|string|max:10|unique:proveedors,telefono',
            'direccion'=> 'required|string|max:200|unique:proveedors,direccion',
        ]);

        $proveedor = new proveedor();

        $proveedor->nombre = $request->input('nombre');
        $proveedor->ruc = $request->input('ruc');
        $proveedor->email = $request->input('email');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->direccion = $request->input('direccion');
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $destinationPath = 'images/imagen/';
            $filename = time() . '-' . $file->getClientOriginalName();
            $uploadSuccess = $request->file('imagen')->move($destinationPath, $filename);
            $proveedor->imagen = $destinationPath . $filename;
        }

        $proveedor->save();
        return back()->with('message','ok');

    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        $productos = Producto::where('id_proveedor', $proveedor->id)->get();
        return view('proveedores.showproveedor', compact('proveedor', 'productos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $proveedor = Proveedor::find($id);

        return view('proveedores.editproveedor', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $proveedor = Proveedor::find($id);

        $proveedor->nombre = $request->input('nombre');
        $proveedor->ruc = $request->input('ruc');
        $proveedor->email = $request->input('email');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->direccion = $request->input('direccion');

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
                if ($proveedor->imagen) {
                    Storage::delete($proveedor->imagen);
                }
                // Actualizar el campo imagen
                $proveedor->imagen = $destinationPath . $filename;
            } else {
                Log::error('La carga de la imagen falló. Ruta destino: ' . $destinationPath);
            }
        }
        $proveedor->save();

        return back()->with('message','Actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proveedor = Proveedor::find($id);
        if ($proveedor->productos()->exists()) {
            return back()->with('error', 'No puedes eliminar un proveedor que tiene un producto habilitado.');
        }

        $proveedor->delete();

        return back();
    }
}
