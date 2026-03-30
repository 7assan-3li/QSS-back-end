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
        Schema::create('bond_registries', function (Blueprint $table) {
            $table->id();
            $table->string('bond_number');
            $table->string('bank_name')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('source_type'); // points_package, verification, request_payment
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('image_hash')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            // تأمين عدم تكرار رقم السند مع نفس البنك
            $table->unique(['bond_number', 'bank_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bond_registries');
    }
};
