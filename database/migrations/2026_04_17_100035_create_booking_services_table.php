<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->string('category')->default('lectura');
            $table->string('delivery_method')->default('whatsapp'); // whatsapp, telefono, videollamada, presencial, entrega
            $table->string('image')->nullable();
            $table->unsignedBigInteger('lunar_product_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_payment')->default(true);
            $table->boolean('show_in_catalog')->default(true);
            $table->unsignedInteger('sort')->default(0);
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'sort']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_services');
    }
};
