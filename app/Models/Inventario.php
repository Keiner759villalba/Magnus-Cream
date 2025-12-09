<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = ['producto_id', 'stock'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
