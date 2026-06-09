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
        Schema::table('users', function (Blueprint $table) {
            $table->string('id_card_hash')->nullable()->after('id_card');
        });

        Schema::table('provider_requests', function (Blueprint $table) {
            $table->string('id_card_hash')->nullable()->after('id_card');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id_card_hash');
        });

        Schema::table('provider_requests', function (Blueprint $table) {
            $table->dropColumn('id_card_hash');
        });
    }
};
