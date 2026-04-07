<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->longText('value')->change();
        });

        // Seed initial policy records
        DB::table('settings')->insertOrIgnore([
            [
                'key' => 'seeker_policy_content',
                'display_name' => 'نص سياسة طالب الخدمة',
                'value' => 'يرجى كتابة بنود سياسة طالب الخدمة هنا...',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'provider_policy_content',
                'display_name' => 'نص سياسة مزود الخدمة',
                'value' => 'يرجى كتابة بنود سياسة مزود الخدمة هنا...',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('value')->change();
        });
        
        DB::table('settings')->whereIn('key', ['seeker_policy_content', 'provider_policy_content'])->delete();
    }
};
