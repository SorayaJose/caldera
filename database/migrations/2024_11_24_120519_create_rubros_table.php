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
        Schema::create('rubros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            //$table->boolean('mostrar')->default(true);
            $table->enum('moneda', ['$', 'U$S'])->default('$');
            $table->enum('tipo', ['P', 'S'])->default('S');
            $table->tinyInteger('color')->default(0);
            //$table->boolean('todos')->default(true);
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
        Schema::dropIfExists('rubros');
    }
};
