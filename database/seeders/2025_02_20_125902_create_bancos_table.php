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
        Schema::create('bancos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 250)->nullable();
            $table->string('numero', 250)->nullable();
            $table->enum('moneda', ['$', 'U$S'])->default('$');
            $table->enum('tipo', ['P', 'S'])->default('S');
            $table->timestamps();
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bancos');
    }
};
