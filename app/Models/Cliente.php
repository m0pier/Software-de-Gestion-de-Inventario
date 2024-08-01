<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeUnit\FunctionUnit;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'email', 'cedula', 'telefono', 'direccion'];


    public function productos(){
        return $this->hasMany(Producto::class);
    }

    public function venta(){
        return $this->hasMany(Venta::class, 'id_cliente');
    }
}
