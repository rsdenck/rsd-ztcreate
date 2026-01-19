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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained()->onDelete('cascade');
            $table->foreignId('discovery_rule_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('key');
            $table->integer('type')->default(0)->comment('0: Zabbix Agent, 2: Trapper, 3: Simple check, 5: Internal, 7: Active Agent, 10: External, 11: Database monitor, 12: IPMI, 13: SSH, 14: Telnet, 15: Calculated, 16: HTTP Agent, 17: SNMP Trap, 18: Dependent, 19: Script, 20: SNMP Agent');
            $table->integer('value_type')->default(3)->comment('0: Float, 1: Character, 2: Log, 3: Unsigned, 4: Text, 5: Binary');
            $table->string('delay')->default('1m');
            $table->string('history')->default('90d');
            $table->string('trends')->default('365d');
            $table->integer('status')->default(0)->comment('0: Enabled, 1: Disabled');
            $table->text('description')->nullable();
            $table->string('units')->nullable();
            $table->string('snmp_oid')->nullable();
            $table->string('url')->nullable();
            $table->text('query_fields')->nullable();
            $table->text('headers')->nullable();
            $table->text('posts')->nullable();
            $table->integer('post_type')->default(0);
            $table->string('timeout')->nullable();
            $table->string('master_item_key')->nullable()->comment('For dependent items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
