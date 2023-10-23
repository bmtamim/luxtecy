<?php

namespace App\Http\Requests\Admin\V1;

use App\Services\Api\V1\PostalCodeService;
use App\Services\Api\V1\ShippingService;
use App\Services\Api\V1\TimeRangeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $shipping_methods = ShippingService::getShippingMethods()->pluck('name')->toArray();

        return [
            'user_token'                       => ['required', 'string', 'exists:user_sessions,token'],
            'shipping_method'                  => ['required', 'string', Rule::in($shipping_methods)],
            'payment_method'                   => ['required', 'string'],
            'delivery_address'                 => ['required', 'array'],
            'delivery_address.name'            => ['required', 'string'],
            'delivery_address.phone'           => ['required', 'string', 'min:10', 'max:11'],
            'delivery_address.address'         => ['required', 'string'],
            'delivery_address.address_details' => ['required', 'string'],
            'delivery_address.latitude'        => ['required', 'string'],
            'delivery_address.longitude'       => ['required', 'string'],
            'delivery_address.postal_code'     => ['required', 'string', Rule::notIn(PostalCodeService::excluded())],
            'delivery_time'                    => [
                'nullable', 'string', Rule::in(TimeRangeService::generateDeliveryRange())
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'delivery_address.postal_code.not_in' => __('Apologies. Your location is currently not in our coverage')
        ];
    }
}
