<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('detalhe_id');
            $table->foreign('detalhe_id')->references('id')->on('detalhes_pedido');
            $table->lineString('name');
            $table->integer('preço');
            $table->lineString('descrição');
            $table->integer('estoque');
            $table->bigInteger('medida_id');
            $table->foreign('medida_id')->references('id')->on('unidade_medida');
            $table->index('name');
            $table->index('descrição');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
