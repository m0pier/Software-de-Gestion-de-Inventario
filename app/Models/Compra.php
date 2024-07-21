<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeUnit\FunctionUnit;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = ['id_proveedor', 'id_user', 'fecha', 'iva', 'total', 'status', 'imagen'];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }
    public function detallecompra(){
        return $this->hasMany(DetalleCompra::class, 'id_compra', 'id');
    }
}
