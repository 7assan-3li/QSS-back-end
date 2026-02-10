<?php
namespace App\constant;
class SystemComplaintStatus
{
const PENDING = 'pending';
const IN_PROGRESS = 'in_progress';
const COMPLETED = 'completed';

public static function all(): array
    {
        return [
            self::PENDING,
            self::IN_PROGRESS,
            self::COMPLETED,
        ];
    }
}