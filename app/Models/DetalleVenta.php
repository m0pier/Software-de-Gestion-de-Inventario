<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeUnit\FunctionUnit;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $fillable = ['id_venta', 'id_producto', 'cantidad', 'precio', 'descuento'];

    public function producto(){
        return $this->belongsTo(Producto::class, 'id_producto');
    }
    public function venta(){
        return $this->belongsTo(Venta::class, 'id_venta', 'id');
    }
}
