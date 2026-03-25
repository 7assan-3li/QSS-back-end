<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('points_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الباقة
            $table->integer('points'); // عدد النقاط
            $table->decimal('price', 10, 2); // السعر
            $table->integer('bonus_points')->default(0); // نقاط إضافية 🎁
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable(); // تاريخ انتهاء الباقة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points_packages');
    }
};
