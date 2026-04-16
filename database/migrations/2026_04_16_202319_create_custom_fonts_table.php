<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_fonts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('family_name');
            $table->string('weight')->default('400');
            $table->string('style')->default('normal');
            $table->string('file_path');
            $table->string('format')->default('woff2');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_fonts');
    }
};
