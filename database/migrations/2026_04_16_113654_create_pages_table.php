<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->longText('excerpt')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->string('template')->default('default');
            $table->json('seo')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->unsignedBigInteger('wc_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
