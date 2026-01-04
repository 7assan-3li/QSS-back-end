<?php
namespace App\constant;
class RequestStatus
{
const PENDING = 'pending';
const CANCELLED = 'cancelled';
const REJECTED = 'rejected';
const ACCEPTED_INITIAL = 'accepted_initial';
const ACCEPTED_PARTIAL_PAID = 'accepted_partial_paid';
const ACCEPTED_FULL_PAID = 'accepted_full_paid';
const COMPLETED = 'completed';
const SUSPENDED = 'suspended'; // موقوف من قبل الإدارة



public static function all(): array
    {
        return [
            self::PENDING,
            self::CANCELLED,
            self::REJECTED,
            self::ACCEPTED_INITIAL,
            self::ACCEPTED_PARTIAL_PAID,
            self::ACCEPTED_FULL_PAID,
            self::COMPLETED,
            self::SUSPENDED,
        ];
    }

}
