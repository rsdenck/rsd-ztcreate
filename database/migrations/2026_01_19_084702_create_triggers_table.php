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
        Schema::create('triggers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained()->onDelete('cascade');
            $table->foreignId('discovery_rule_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('expression');
            $table->text('recovery_expression')->nullable();
            $table->integer('priority')->default(3)->comment('0: Not classified, 1: Information, 2: Warning, 3: Average, 4: High, 5: Disaster');
            $table->integer('status')->default(0);
            $table->text('description')->nullable();
            $table->integer('recovery_mode')->default(0)->comment('0: Expression, 1: Recovery expression, 2: None');
            $table->integer('correlation_mode')->default(0);
            $table->string('correlation_tag')->nullable();
            $table->integer('manual_close')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('triggers');
    }
};
