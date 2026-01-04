<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Service;

class SubServiceBelongsToMain implements Rule
{
    protected $mainServiceId;

    public function __construct($mainServiceId)
    {
        $this->mainServiceId = $mainServiceId;
    }

    public function passes($attribute, $value)
    {
        // $value يحتوي على معرف الخدمة الفرعية
        $service = Service::find($value);

        if (!$service) {
            return false;
        }

        // التحقق من أن service_id (الأب) يساوي mainServiceId
        return $service->parent_service_id == $this->mainServiceId;
    }

    public function message()
    {
        return 'إحدى الخدمات الفرعية لا تتبع الخدمة الرئيسية المحددة.';
    }
}
