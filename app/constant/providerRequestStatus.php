<?php
namespace App\constant;
class providerRequestStatus
{
const PENDING = 'pending';
const REJECTED = 'rejected';
const ACCEPTED = 'accepted';

public static function all(): array
    {
        return [
            self::PENDING,
            self::REJECTED,
            self::ACCEPTED,
        ];
    }
}