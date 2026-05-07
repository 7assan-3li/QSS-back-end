<?php
namespace App\constant;
class RequestComplaintStatus
{
const PENDING = 'pending';
const REVIEWED = 'reviewed';

public static function all(): array{
    return[
        self::PENDING,
        self::REVIEWED,
    ];
}
}
