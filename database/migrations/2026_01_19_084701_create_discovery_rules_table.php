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
        Schema::create('discovery_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('key');
            $table->integer('type')->default(0);
            $table->string('delay')->default('1h');
            $table->text('description')->nullable();
            $table->string('snmp_oid')->nullable();
            $table->string('url')->nullable();
            $table->text('query_fields')->nullable();
            $table->text('headers')->nullable();
            $table->text('posts')->nullable();
            $table->integer('post_type')->default(0);
            $table->string('timeout')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discovery_rules');
    }
};
