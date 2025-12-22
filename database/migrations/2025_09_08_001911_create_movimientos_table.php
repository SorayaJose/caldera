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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mov_id');
            $table->enum('mov_tipo', ['M', 'V'])->default('M');
            $table->enum('moneda', ['$', 'U$S'])->default('$');
            $table->double('importe', 12, 2)->default(0);
            $table->enum('tipo', ['P', 'S'])->default('S');
            
            $table->foreignId('cuenta_id')
                  ->nullable()
                  ->constrained('cuentas')
                  ->nullOnDelete();
            
            $table->foreignId('vencimiento_id')
                  ->nullable()
                  ->constrained('vencimientos')
                  ->nullOnDelete();
            
            $table->unsignedBigInteger('destino')->nullable(); 
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
        Schema::dropIfExists('movimientos');
    }
};
