<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'categoria',
        'precio_compra',
        'precio_venta',
        'proveedor_id',
    ];

    public function inventario()
    {
        return $this->hasOne(\App\Models\Inventario::class, 'producto_id');
    }
}
