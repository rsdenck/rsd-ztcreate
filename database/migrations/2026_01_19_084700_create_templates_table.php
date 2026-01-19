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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('uuid')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('vendor_version')->nullable();
            $table->text('description')->nullable();
            $table->string('groups')->comment('Comma separated groups');
            $table->string('zabbix_version')->default('7.0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
