<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('theme_templates', function (Blueprint $table) {
            $table->string('trigger_type')->nullable()->after('conditions');
            $table->integer('trigger_value')->nullable()->after('trigger_type');
            $table->string('frequency')->default('always')->after('trigger_value');
            $table->string('max_width')->default('md')->after('frequency');
        });
    }

    public function down(): void
    {
        Schema::table('theme_templates', function (Blueprint $table) {
            $table->dropColumn(['trigger_type', 'trigger_value', 'frequency', 'max_width']);
        });
    }
};
