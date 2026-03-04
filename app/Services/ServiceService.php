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
        $meetingservice = [
            "type" => ServiceType::MEETING,
            "provider_id" => $providerId,
            "name" => '_meeting',
            "description" => 'هذه الخدمة طلب حضور او اجتماع تم انشاؤها بواسطة النظام',
            "price" => 0,
            "category_id" => 1,
            "distance_based_price" => 1,
        ];

        $customservice = [
            "type" => ServiceType::CUSTOM,
            "provider_id" => $providerId,
            "name" => '_custom',
            "description" => 'هذه الخدمة طلب خدمة مخصصة تم انشاؤها بواسطة النظام',
            "price" => 0,
            "category_id" => 1,
            "distance_based_price" => 1,
        ];

        $this->serviceRepository->create($meetingservice);
        $this->serviceRepository->create($customservice);




        return [
            "meeting" => $meetingservice,
            "custom" => $customservice
        ];
    }

}