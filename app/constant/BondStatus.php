<?php
namespace App\constant;
class BondStatus
{
const PENDING = 'pending';
const REJECTED = 'rejected';
const APPROVED = 'approved';

public static function all(): array{
    return[
        self::PENDING,
        self::REJECTED,
        self::APPROVED,
    ];
}
}