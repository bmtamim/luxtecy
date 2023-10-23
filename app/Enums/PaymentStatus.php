<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case FAILED = 'failed';
    case PAID = 'paid';
    case UNPAID = 'unpaid';

    public function getStatusLabel(): string
    {
        return match ($this) {
            self::FAILED => __('Failed'),
            self::PAID => __('Paid'),
            self::UNPAID => __('Unpaid'),
        };
    }
}
