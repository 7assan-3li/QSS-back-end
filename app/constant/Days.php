<?php
namespace App\constant;
class Days
{
const SATURDAY = 'saturday';
const SUNDAY = 'sunday';
const MONDAY = 'monday';
const TUESDAY = 'tuesday';
const WEDNESDAY = 'wednesday';
const THURSDAY = 'thursday';
const FRIDAY = 'friday';

public static function all(): array{
    return[
        self::SATURDAY,
        self::SUNDAY,
        self::MONDAY,
        self::TUESDAY,
        self::WEDNESDAY,
        self::THURSDAY,
        self::FRIDAY,
    ];
}
}