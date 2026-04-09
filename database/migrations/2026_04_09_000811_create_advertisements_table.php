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
        Schema::create('advertisements', function (Blueprint $request) {
            $request->id();
            $request->string('title')->nullable();
            $request->string('image_path');
            $request->enum('type', ['carousel', 'popup', 'section'])->default('carousel');
            
            // Redirection logic
            $request->enum('target_type', ['service', 'category', 'external', 'none'])->default('none');
            $request->foreignId('target_id')->nullable(); 
            $request->string('external_link')->nullable();
            
            // Audience & Display
            $request->enum('user_type', ['all', 'client', 'provider'])->default('all');
            $request->boolean('is_active')->default(true);
            $request->integer('sort_order')->default(0);
            
            // Scheduling
            $request->timestamp('starts_at')->useCurrent();
            $request->timestamp('ends_at')->nullable();
            
            $request->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
