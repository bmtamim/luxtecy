<?php

namespace App\Enums;

enum ShippingUnitType: string
{
    case KM = 'km'; //kilometer
    case QTY = 'quantity';
    case MI = 'mi'; //miles
    case FIXED = 'fixed'; //miles
}
