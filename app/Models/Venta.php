<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeUnit\FunctionUnit;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['id_cliente', 'id_user', 'fecha_venta', 'status', 'iva', 'total'];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
    public function DetalleVentas(){
        return $this->hasMany(DetalleVenta::class, 'id_venta', 'id');
    }
}
