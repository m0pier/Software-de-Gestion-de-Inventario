<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'codigo', 'descripcion', 'id_categoria', 'id_proveedor', 'precio', 'stock', 'status'];

    public function categoria(){
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }
}
