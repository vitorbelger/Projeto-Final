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
        Schema::table('solicitacoes', function (Blueprint $table) {
            $table->timestamp('data_finalizacao')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('solicitacoes', function (Blueprint $table) {
            $table->dropColumn('data_finalizacao');
        });
    }
};
