<?php

namespace App\Enums;

enum OrderStatus :string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Shipped = 'shipped';
    case Completed = 'completed';

    public static function getStatuses()
    {
        return [
            self::Confirmed, self::Pending, self::Cancelled, self::Shipped, self::Completed
        ];
    }
}
