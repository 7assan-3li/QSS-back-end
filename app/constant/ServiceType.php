<?php
namespace App\constant;
class ServiceType
{
    public const MAIN = 'main';
    public const MEETING = 'meeting';
    public const CUSTOM = 'custom';


    public function all()
    {
        return [
            self::MAIN,
            self::MEETING,
            self::CUSTOM
        ];
    }
}
