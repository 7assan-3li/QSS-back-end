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
        Schema::table('point_transactions', function (Blueprint $table) {
            $table->foreignId('seeker_id')->nullable()->change();
            $table->foreignId('provider_id')->nullable()->change();
            $table->foreignId('request_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('point_transactions', function (Blueprint $table) {
            $table->foreignId('seeker_id')->nullable(false)->change();
            $table->foreignId('provider_id')->nullable(false)->change();
            $table->foreignId('request_id')->nullable(false)->change();
        });
    }
};
