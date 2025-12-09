<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('clientes', 'identificacion')) {
            Schema::table('clientes', function (Blueprint $table) {
                $table->string('identificacion')->nullable()->index();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('clientes', 'identificacion')) {
            Schema::table('clientes', function (Blueprint $table) {
                // drop index if exists then drop column
                // some DB engines drop indexes automatically with the column
                if (Schema::hasColumn('clientes', 'identificacion')) {
                    $table->dropColumn('identificacion');
                }
            });
        }
    }
};
    

