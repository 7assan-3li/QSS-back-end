<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->request->user;
        $profile = $user ? $user->profile : null;

        return [
            'id' => $this->id,
            'rating' => (float) $this->rating,
            'comment' => $this->comment,
            'is_hidden' => (boolean) $this->is_hidden,
            'user' => [
                'id' => $user->id ?? null,
                'name' => $user->name ?? 'مستخدم مجهول',
                'image_url' => ($profile && $profile->image_path) ? Storage::url($profile->image_path) : null,
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
