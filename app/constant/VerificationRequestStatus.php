<?php
namespace App\constant;
class VerificationRequestStatus
{
const PENDING = 'pending';
const REJECTED  = 'rejected';
const ACCEPTED  = 'accepted';
const EXPIRED   = 'expired';

public static function all(): array{
    return[
        self::PENDING,
        self::REJECTED,
        self::ACCEPTED,
        self::EXPIRED
    ];
}
}
