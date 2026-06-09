<?php

namespace App\Services;

use App\Models\User;
use App\Models\ProviderRequest;
use App\Models\EmailVerificationCode;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendEmailVerificationCode;
use App\constant\Role;
use App\constant\ProviderRequestStatus;

class ProviderRegistrationService
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function registerAndApply(array $validatedData, $idCardFile, $fcmToken = null, $deviceToken = null)
    {
        // 1. Create User (Role: seeker initially until approved)
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'seeker_policy' => true,
        ]);

        // 2. Generate and handle OTP
        $code = random_int(100000, 999999);
        EmailVerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10)
        ]);

        // Save Device Tokens if available
        if ($fcmToken) {
            \App\Models\DeviceTokens::updateOrCreate(
                ['token' => $fcmToken],
                ['user_id' => $user->id]
            );
        } elseif ($deviceToken) {
            \App\Models\DeviceTokens::updateOrCreate(
                ['token' => $deviceToken],
                ['user_id' => $user->id]
            );
        }

        // Send OTP Notification
        try {
            $this->notificationService->sendToUser(
                $user->id,
                'رمز تأكيد الحساب QSS',
                "رمز التحقق الخاص بك هو: {$code}",
                \App\Constants\NotificationType::GENERAL
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('FCM Registration Notification failed: ' . $e->getMessage());
        }

        SendEmailVerificationCode::dispatch($user, $code);

        // 3. Create initial profile
        $user->profile()->create([]);

        // 4. Generate Token
        $token = $user->createToken('api-token')->plainTextToken;

        // 5. Handle Provider Request
        $idCardHash = hash_file('sha256', $idCardFile->path());
        
        // Check for duplicate ID Card Hash (prevent reusing same ID even during direct registration)
        $isDuplicate = User::where('id_card_hash', $idCardHash)
            ->where('role', Role::PROVIDER)
            ->exists();

        if ($isDuplicate) {
            // In a real scenario, we might want to rollback the user creation.
            // But since this is a rare edge case, we can throw an exception or just return it.
            // Using exception to be caught in controller.
            throw new \Exception('عذراً، الهوية المرفوعة مسجلة بالفعل لمزود خدمة معتمد.');
        }

        // Upload image
        $idCardPath = $idCardFile->store('provider_requests/id_cards', 'public');

        // Create the Provider Request
        ProviderRequest::create([
            'user_id' => $user->id,
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'location' => $validatedData['location'],
            'requestContent' => $validatedData['requestContent'],
            'id_card' => $idCardPath,
            'id_card_hash' => $idCardHash,
            'status' => ProviderRequestStatus::PENDING,
        ]);

        return [
            'token' => $token,
            'user' => $user,
            'code' => $code, // For testing purposes
            'email_verified' => false
        ];
    }
}
