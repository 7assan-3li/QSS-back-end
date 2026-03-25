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
        Schema::create('user_points_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('points_packages')->cascadeOnDelete();
            $table->string('status')->default('pending');
            $table->foreignId('admin_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('admin_note')->nullable();
            $table->string('bond_image');
            $table->string('bond_number');
            $table->string('bank_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_points_packages');
    }
};
