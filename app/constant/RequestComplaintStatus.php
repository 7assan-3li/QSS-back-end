<?php
namespace App\constant;
class requestComplaintStatus
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
