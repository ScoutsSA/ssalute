<?php

namespace App\Constants;

class AamStatuses
{
    public const PENDING = 'pending';
    public const APPROVED = 'approved';
    public const DECLINED = 'declined';

    public const STATUSES = [
        self::PENDING => 'Pending',
        self::APPROVED => 'Approved',
        self::DECLINED => 'Declined',
    ];
}
