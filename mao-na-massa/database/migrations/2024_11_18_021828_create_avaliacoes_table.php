<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitacao_id');  // Relacionamento com a solicitação
            $table->unsignedBigInteger('avaliador_id');    // Usuário que faz a avaliação
            $table->unsignedBigInteger('avaliado_id');     // Usuário avaliado
            $table->tinyInteger('nota')->unsigned()->comment('Nota de 0 a 5'); // Nota de avaliação
            $table->text('comentario')->nullable();        // Comentário opcional
            $table->timestamps();

            // Definição de chaves estrangeiras
            $table->foreign('solicitacao_id')
                ->references('id')->on('solicitacoes')
                ->onDelete('cascade');

            $table->foreign('avaliador_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('avaliado_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('avaliacoes');
    }
};
