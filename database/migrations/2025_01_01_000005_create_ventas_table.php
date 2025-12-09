<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            // cliente_id debe ser nullable si la FK usa SET NULL
            $table->foreignId('cliente_id')
                  ->nullable()
                  ->constrained('clientes')
                  ->nullOnDelete();

            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
