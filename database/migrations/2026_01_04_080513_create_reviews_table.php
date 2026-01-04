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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->decimal('rating', 2, 1)->check('rating >= 1 AND rating <= 5')->default(0);
            $table->text('comment')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->foreignId('request_id')
                ->constrained('requests')
                ->onDelete('cascade');
            $table->unique('request_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};