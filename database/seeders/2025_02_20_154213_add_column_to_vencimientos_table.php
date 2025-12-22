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
        Schema::table('vencimientos', function (Blueprint $table) {
            $table->string('descripcion', 250)->nullable();
            $table->foreignId('banco_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', ['P', 'S'])->default('S');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vencimientos', function (Blueprint $table) {
            $table->dropColumn('descripcion');
            $table->dropColumn('banco_id');
            $table->dropColumn('tipo');
        });
    }
};
