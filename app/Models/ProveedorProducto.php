<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProveedorProducto extends Model
{
    use HasFactory;

    protected $table = 'proveedor_productos';

    protected $fillable = [
        'proveedor_id',
        'nombre',
        'cantidad',
        'precio_compra',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}
