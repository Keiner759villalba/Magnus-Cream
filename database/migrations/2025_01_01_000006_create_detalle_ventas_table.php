<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentasTable extends Migration
{
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();

            // Si quieres que al borrar una venta se borren sus detalles:
            $table->foreignId('venta_id')
                  ->constrained('ventas')
                  ->cascadeOnDelete();

            // producto_id debe ser nullable si la FK usa SET NULL
            $table->foreignId('producto_id')
                  ->nullable()
                  ->constrained('productos')
                  ->nullOnDelete();

            $table->integer('cantidad')->default(1);
            $table->decimal('subtotal', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_ventas');
    }
}
