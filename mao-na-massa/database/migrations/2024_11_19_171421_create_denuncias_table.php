<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitacao_id');
            $table->unsignedBigInteger('denunciante_id');
            $table->unsignedBigInteger('denunciado_id');
            $table->text('comentario');
            $table->timestamps();

            $table->foreign('solicitacao_id')
                ->references('id')->on('solicitacoes')
                ->onDelete('cascade');

            $table->foreign('denunciante_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('denunciado_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncias');
    }
};
