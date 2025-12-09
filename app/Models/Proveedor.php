<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'empresa',
        'telefono',
    ];

    public function productos()
    {
        return $this->hasMany(\App\Models\Producto::class, 'proveedor_id');
    }

    // relación a los productos comprados (registro de compras de proveedor)
    public function productosComprados()
    {
        return $this->hasMany(\App\Models\ProveedorProducto::class, 'proveedor_id');
    }
}
