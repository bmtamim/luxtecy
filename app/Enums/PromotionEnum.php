<?php

namespace App\Enums;

enum PromotionEnum: string
{
    //Type
    case FIXED = 'fixed';
    case PERCENTAGE = 'percentage';
    case PRODUCT = 'product';

    //Applied On

    case DELIVERY_FEE = 'deliver-fee';
    case CART = 'cart';

}
