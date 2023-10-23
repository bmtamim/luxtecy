<?php

namespace App\DTO\Api\V1;

use App\Abstracts\DataTransferObject;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Requests\Admin\V1\CheckoutRequest;
use App\Services\Api\V1\CheckoutCalculateService;
use Carbon\Carbon;
use DateTime;

class OrderDTO extends DataTransferObject
{
    public float $sub_total;
    public float $total;
    public string $status;
    public ?string $shipping_method;
    public ?float $shipping_fee;
    public ?DateTime $delivery_time;
    public ?string $delivery_time_slot;
    public ?string $delivery_address;
    public ?string $delivery_address_details;
    public ?string $delivery_name;
    public ?string $delivery_email;
    public ?string $delivery_phone;
    public ?string $delivery_latitude;
    public ?string $delivery_longitude;
    public ?string $delivery_postal_code;

    public ?string $payment_method;
    public ?string $transaction_id;
    public ?string $payment_status;

    public static function create(CheckoutRequest $request, CheckoutCalculateService $orderData): OrderDTO
    {
        $delivery_time       = null;
        $delivery_time_slots = $request->filled('delivery_time') ? cleanUp($request->input('delivery_time')) : null;
        if ($delivery_time_slots) {
            $delivery_time_data = explode('-', $delivery_time_slots);
            $delivery_time      = isset($delivery_time_data[1]) ? Carbon::parse(ltrim($delivery_time_data[1])) : null;
        }

        return new self([
            'sub_total'                => $orderData->cart->subTotal(),
            'total'                    => $orderData->total(),
            'status'                   => OrderStatus::PENDING_PAYMENT->value,
            'shipping_method'          => cleanUp($request->input('shipping_method')),
            'shipping_fee'             => $orderData->deliveryFee(),
            'delivery_time'            => $delivery_time,
            'delivery_time_slot'       => $delivery_time_slots,
            'delivery_address'         => cleanUp($request->input('delivery_address.address')),
            'delivery_address_details' => cleanUp($request->input('delivery_address.address_details')),
            'delivery_name'            => cleanUp($request->input('delivery_address.name')),
            'delivery_email'           => null,
            'delivery_phone'           => cleanUp($request->input('delivery_address.phone')),
            'delivery_latitude'        => cleanUp($request->input('delivery_address.latitude')),
            'delivery_longitude'       => cleanUp($request->input('delivery_address.longitude')),
            'delivery_postal_code'     => cleanUp($request->input('delivery_address.postal_code')),
            'payment_method'           => cleanUp($request->input('payment_method')),
            'payment_status'           => PaymentStatus::UNPAID->value,
        ]);
    }

    public function toArray(): array
    {
        return [
            'sub_total'                => $this->sub_total,
            'total'                    => $this->total,
            'status'                   => $this->status,
            'shipping_method'          => $this->shipping_method,
            'shipping_fee'             => $this->shipping_fee,
            'delivery_time'            => $this->delivery_time,
            'delivery_time_slot'       => $this->delivery_time_slot,
            'delivery_address'         => $this->delivery_address,
            'delivery_address_details' => $this->delivery_address_details,
            'delivery_name'            => $this->delivery_name,
            'delivery_email'           => $this->delivery_email,
            'delivery_phone'           => $this->delivery_phone,
            'delivery_latitude'        => $this->delivery_latitude,
            'delivery_longitude'       => $this->delivery_longitude,
            'delivery_postal_code'     => $this->delivery_postal_code,
            'payment_method'           => $this->payment_method,
            'payment_status'           => $this->payment_status,
        ];
    }

    public function payment($transaction_id, bool $is_paid): array
    {
        $data = [
            'transaction_id' => $transaction_id,
            'payment_status' => $is_paid ? PaymentStatus::PAID->value : PaymentStatus::FAILED->value,
        ];
        if ($is_paid) {
            $data['status'] = OrderStatus::PENDING->value;
        }

        return $data;
    }


}
