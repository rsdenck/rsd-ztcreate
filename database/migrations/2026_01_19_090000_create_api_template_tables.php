<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_definitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained()->onDelete('cascade');
            $table->string('base_url');
            $table->enum('api_type', ['REST', 'SOAP', 'GraphQL', 'Custom'])->default('REST');
            $table->string('vendor')->nullable();
            $table->timestamps();
        });

        Schema::create('api_auth_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('api_definition_id')->constrained()->onDelete('cascade');
            $table->enum('auth_type', ['None', 'ApiKey', 'Bearer', 'OAuth2', 'Basic', 'Custom'])->default('None');
            $table->text('auth_params')->nullable(); // JSON store for keys, tokens, etc.
            $table->timestamps();
        });

        Schema::create('api_endpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('api_definition_id')->constrained()->onDelete('cascade');
            $table->string('path');
            $table->string('method')->default('GET');
            $table->text('payload')->nullable();
            $table->text('headers')->nullable(); // JSON
            $table->string('delay')->default('1m');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_endpoints');
        Schema::dropIfExists('api_auth_configs');
        Schema::dropIfExists('api_definitions');
    }
};
