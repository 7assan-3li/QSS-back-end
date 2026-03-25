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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('required_partial_percentage')->default(40);
            $table->foreignId('provider_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->onDelete('set null');
            $table->foreignId('parent_service_id')->nullable()->constrained('services')->onDelete('cascade');
            $table->string('type')->default('main');
            $table->string('status')->default('available');
            $table->string('image_path')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_active')->default(true);
            $table->boolean('distance_based_price')->default(false);
            $table->decimal('price_per_km', 8, 2)->nullable();
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
