<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'ruc', 'email', 'direccion', 'telefono'];

    public function productos(){
        return $this->hasMany(Producto::class, 'id_proveedor');
    }
}
