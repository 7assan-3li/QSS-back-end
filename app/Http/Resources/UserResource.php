<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'status' => $this->status,
            'email_verified_at' => $this->email_verified_at,
            'provider_verified_until' => $this->provider_verified_until,
            'bonus_points' => $this->bonus_points,
            'paid_points' => $this->paid_points,
            'seeker_policy' => $this->seeker_policy,
            'banks' => $this->whenLoaded('banks'),
            'main_services' => $this->whenLoaded('main_services'),
            'services' => $this->whenLoaded('services'),
            'rating_avg' => (float) ($this->rating_avg ?? 0),
            'is_verified' => $this->isVerified(),
            'is_suspended_for_commissions' => $this->role === \App\constant\Role::PROVIDER ? ($this->getUnpaidCommissionsCount() >= 3) : false,
            'suspended_message' => ($this->role === \App\constant\Role::PROVIDER && $this->getUnpaidCommissionsCount() >= 3) ? 'عذراً، لديك 3 عمولات أو أكثر غير مدفوعة. يرجى سداد العمولات المستحقة لتتمكن من استخدام كافة ميزات التطبيق.' : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
