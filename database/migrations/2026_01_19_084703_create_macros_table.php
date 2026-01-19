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
        Schema::create('macros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained()->onDelete('cascade');
            $table->foreignId('discovery_rule_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('macro');
            $table->string('value')->nullable();
            $table->integer('type')->default(0)->comment('0: Text, 1: Secret, 2: Vault');
            $table->text('description')->nullable();
            $table->string('lld_macro')->nullable()->comment('For LLD macro mapping');
            $table->string('path')->nullable()->comment('For LLD macro path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('macros');
    }
};
