<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('type')->default('percent'); // percent | fixed
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('min_cart', 10, 2)->nullable();
            $table->unsignedInteger('uses_limit')->nullable();
            $table->unsignedInteger('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // Seed the 3 known coupons from WP
        \App\Models\Coupon::insert([
            ['code' => 'rit50', 'type' => 'percent', 'amount' => 50, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'mami', 'type' => 'percent', 'amount' => 10, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'gratis', 'type' => 'percent', 'amount' => 100, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
