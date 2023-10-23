<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PENDING_DELIVERY = 'pending-delivery';
    case PENDING_PAYMENT = 'payment-pending';
    case FAILED_PAYMENT = 'payment-failed';
    case CONFIRMED = 'confirmed';
    case COMPLETED = 'completed';
    case ON_HOLD = 'on-hold';
    case FAILED = 'failed';
    case APPROVED = 'approved';
    case SUCCESS = 'success';
    case DELIVERED = 'delivered';
    case CANCEL = 'cancel';

    public function getStatusLabel(): string
    {
        return match ($this) {
            self::PENDING => __('pending action'),
            self::PENDING_DELIVERY => __('pending delivery'),
            self::PENDING_PAYMENT => __('pending payment'),
            self::CONFIRMED => __('confirmed'),
            self::ON_HOLD => __('on hold'),
            self::FAILED => __('failed'),
            self::APPROVED => __('approved'),
            self::SUCCESS => __('success'),
            self::DELIVERED => __('delivered'),
            self::CANCEL => __('cancel'),
            self::COMPLETED => __('Completed'),
            self::FAILED_PAYMENT => __('Payment Failed'),
        };
    }

    public static function nonEditableStatuses(): array
    {
        return [
            self::COMPLETED->value,
            self::DELIVERED->value
        ];
    }

}
