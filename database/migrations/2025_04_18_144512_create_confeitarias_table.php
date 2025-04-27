<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('confeitarias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('ll');
            $table->string('cep');
            $table->string('endereco');
            $table->string('end_numero');
            $table->string('telefone');
            $table->string('logo')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // CHAVE ESTRANGEIRA PARA USER
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('confeitarias', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // REMOVE A CHAVE
        });

        Schema::dropIfExists('confeitarias'); // REMOVE A TABELA
    }

};
