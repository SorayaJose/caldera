<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::table('tmp_movimientos', function (Blueprint $table) {
            $table->foreignId('vencimiento_id')
            ->nullable()
            ->constrained('vencimientos')
            ->nullOnDelete();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        Schema::table('tmp_movimientos', function (Blueprint $table) {
            $table->dropColumn('vencimiento_id');
        });
        */
    }
};
