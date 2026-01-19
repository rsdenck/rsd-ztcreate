<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela para partes de uma expressão (para o builder inteligente)
        Schema::create('trigger_expressions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trigger_id')->constrained()->onDelete('cascade');
            $table->string('logical_operator')->nullable(); // AND, OR (para ligar à expressão anterior)
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Tabela para funções usadas em cada parte da expressão
        Schema::create('trigger_functions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trigger_expression_id')->constrained()->onDelete('cascade');
            $table->string('item_key');
            $table->string('function_name'); // last, avg, count, etc.
            $table->string('parameters')->nullable(); // ex: "5m", "10"
            $table->string('operator'); // >, <, =, etc.
            $table->string('threshold'); // valor ou macro
            $table->timestamps();
        });

        // Tabela para mapeamento de dependências entre triggers
        Schema::create('trigger_dependencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trigger_id')->constrained('triggers')->onDelete('cascade');
            $table->foreignId('depends_on_trigger_id')->constrained('triggers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trigger_dependencies');
        Schema::dropIfExists('trigger_functions');
        Schema::dropIfExists('trigger_expressions');
    }
};
