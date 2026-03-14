<?php

namespace App\Services;

use App\constant\ServiceType;
use App\Repository\ServiceRepository;
use Auth;
class ServiceService
{
    public function __construct(private ServiceRepository $serviceRepository)
    {
    }

    public function createMeetingCustomSerivce(int $providerId)
    {
        $hasMeeting = \App\Models\Service::where('provider_id', $providerId)
            ->where('type', \App\constant\ServiceType::MEETING)
            ->exists();

        $hasCustom = \App\Models\Service::where('provider_id', $providerId)
            ->where('type', \App\constant\ServiceType::CUSTOM)
            ->exists();

        $meetingservice = null;
        if (!$hasMeeting) {
            $meetingservice = [
                "type" => \App\constant\ServiceType::MEETING,
                "provider_id" => $providerId,
                "name" => '_meeting',
                "description" => 'هذه الخدمة طلب حضور او اجتماع تم انشاؤها بواسطة النظام',
                "price" => 0,
                "distance_based_price" => true,
                "price_per_km" => 0,
                "is_active" => true,
            ];
            $this->serviceRepository->create($meetingservice);
        }

        $customservice = null;
        if (!$hasCustom) {
            $customservice = [
                "type" => \App\constant\ServiceType::CUSTOM,
                "provider_id" => $providerId,
                "name" => '_custom',
                "description" => 'هذه الخدمة طلب خدمة مخصصة تم انشاؤها بواسطة النظام',
                "price" => 0,
                "category_id" => 1,
                "distance_based_price" => 1,
            ];
            $this->serviceRepository->create($customservice);
        }

        return [
            "meeting" => $meetingservice,
            "custom" => $customservice
        ];
    }

}