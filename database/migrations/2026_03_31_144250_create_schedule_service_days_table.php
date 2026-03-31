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
        Schema::create('schedule_service_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_service_id')->constrained()->onDelete('cascade');
            $table->string('day');
            $table->timestamps();
            
            $table->index(['schedule_service_id', 'day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_service_days');
    }
};
