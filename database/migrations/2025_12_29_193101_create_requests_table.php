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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_price', 10, 2)->unsigned();
            $table->decimal('money_paid', 10, 2)->nullable();
            $table->boolean('commission_paid')->default(false);
            $table->string('status')->default('pending');
            $table->text('message')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('address')->nullable();
            $table->integer('bonus_points_awarded')->default(0);
            $table->decimal('commission_amount', 10, 2)->default(0);
            $table->decimal('commission_amount_paid', 10, 2)->default(0);
            $table->timestamp('end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};