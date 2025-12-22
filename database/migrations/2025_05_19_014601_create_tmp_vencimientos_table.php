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
        Schema::create('tmp_vencimientos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->enum('moneda', ['$', 'U$S'])->default('$');
            $table->tinyInteger('importe')->default(0); // double 12, 2
            $table->string('concepto');
            $table->foreignId('rubro_id')->nullable();
            $table->enum('tipo', ['P', 'S'])->default('S');
            $table->foreignId('cuenta_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tmp_vencimientos');
    }
};
