<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\constant\Role;
use App\constant\RequestStatus;
use App\Models\Request as ModelsRequest;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->whenLoaded('user');
        $stats = null;

        if ($user && $user->role === Role::PROVIDER) {
            $servicesIds = $user->services()->pluck('id');
            
            $stats = [
                'rating_avg' => (float) $user->rating_avg,
                'services_count' => $user->main_services()->count(),
                'requests_count' => ModelsRequest::whereHas('services', function($q) use ($servicesIds) {
                    $q->whereIn('services.id', $servicesIds);
                })->count(),
                'completed_requests_count' => ModelsRequest::whereHas('services', function($q) use ($servicesIds) {
                    $q->whereIn('services.id', $servicesIds);
                })->where('status', RequestStatus::COMPLETED)->count(),
            ];
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'bio' => $this->bio,
            'job_title' => $this->job_title,
            'image_path' => $this->image_path,
            'image_url' => $this->image_path ? Storage::url($this->image_path) : null,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'provider_stats' => $stats,
            'user' => new UserResource($user),
            'profile_phones' => $this->whenLoaded('profilePhones'),
            'previous_works' => $this->whenLoaded('previousWorks'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
