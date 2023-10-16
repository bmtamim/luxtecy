<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case FAILED = 'failed';
    case PAID = 'paid';
    case UNPAID = 'unpaid';
}
