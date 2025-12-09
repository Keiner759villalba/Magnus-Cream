<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    // campos permitidos: sku (identificador usado en ventas), precio_compra = costo, precio_venta, etc.
    protected $fillable = [
        'nombre',
        'categoria',
        'precio_compra',
        'precio_venta',
        'proveedor_id',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function inventario()
    {
        return $this->hasOne(Inventario::class, 'producto_id');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}


