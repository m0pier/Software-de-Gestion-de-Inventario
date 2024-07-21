<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.listcliente', compact("clientes"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.addcliente');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validacion = $request->validate([
            'nombres'=> 'required|string|max:120',
            'email'=> 'required|string|max:50|unique:clientes,email',
            'cedula'=> 'required|string|min:10|unique:clientes,cedula',
            'telefono'=> 'required|string|min:10|unique:clientes,telefono',
            'direccion'=> 'required|string|max:200|unique:clientes,direccion',
        ]);

        $cliente = new Cliente();
        $cliente->nombres = $request->input('nombres');
        $cliente->email = $request->input('email');
        $cliente->cedula = $request->input('cedula');
        $cliente->telefono = $request->input('telefono');
        $cliente->direccion = $request->input('direccion');
        $cliente->save();

        return back()->with('message','ok');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = Cliente::find($id);
        return view('clientes.editcliente', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function show(Cliente $cliente){
        return view('clientes.show-cliente', compact('cliente'));
    }
    public function update(Request $request, string $id)
    {
        $validacion = $request->validate([
            'nombres'=> 'required|string|max:120',
            'email'=> 'required|string|max:50',
            'cedula'=> 'required|string|min:10',
            'telefono'=> 'required|string|min:10',
            'direccion'=> 'required|string|max:200',
        ]);

        $cliente = Cliente::find($id);
        $cliente->nombres = $request->input('nombres');
        $cliente->email = $request->input('email');
        $cliente->cedula = $request->input('cedula');
        $cliente->telefono = $request->input('telefono');
        $cliente->direccion = $request->input('direccion');
        $cliente->save();

        return back()->with('message','ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();
        return back();
    }
}
