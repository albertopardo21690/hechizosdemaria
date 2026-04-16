<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theme_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->json('blocks')->nullable();
            $table->json('conditions')->nullable();
            $table->unsignedInteger('priority')->default(10);
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->index(['location', 'is_active', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theme_templates');
    }
};
