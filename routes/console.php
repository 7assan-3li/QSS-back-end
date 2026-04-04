<?php

use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Models\User;

Schedule::call(function () {
    // سحب علامة التوثيق وتأريخ انتهاء طلب التوثيق الأساسي (مع فترة سماح)
    $graceDays = \App\Models\Setting::where('key', 'returning_free_verification_days')->value('value') ?? 0;
    
    $expiredUsers = User::where('verification_provider', true)
        ->whereNotNull('provider_verified_until')
        ->where('provider_verified_until', '<', now()->subDays($graceDays))
        ->get();

    foreach ($expiredUsers as $user) {
        $expirationDate = $user->provider_verified_until;
        $user->update(['verification_provider' => false]);
        
        // تحويل حالة الطلب للـ "انتهاء" فقط إذا تم قبوله "قبل" تاريخ الانتهاء الحقيقي (قبل البدء في فترة السماح)
        \App\Models\VerificationRequest::where('user_id', $user->id)
            ->where('status', \App\constant\VerificationRequestStatus::ACCEPTED)
            ->where('created_at', '<', $expirationDate) 
            ->update(['status' => \App\constant\VerificationRequestStatus::EXPIRED]);
    }

    // التنظيف الثانوي: الهويات المقبولة التي لم تُفعّل باشتراك لفترة طويلة (Stale Identity)
    $staleDays = \App\Models\Setting::where('key', 'stale_identity_expiry_days')->value('value') ?? 7;
    \App\Models\VerificationRequest::where('status', \App\constant\VerificationRequestStatus::ACCEPTED)
        ->whereHas('user', function($q) {
            $q->where('verification_provider', false); // فقط لمن ليس لديهم توثيق نشط حالياً
        })
        ->where('updated_at', '<', now()->subDays($staleDays))
        ->update(['status' => \App\constant\VerificationRequestStatus::EXPIRED]);
})->daily();
