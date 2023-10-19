<?php

namespace App\Http\Requests\Api\V1;

use App\Services\Api\V1\ShippingService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutCalculateRequest extends FormRequest
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
            'shipping_method'                  => ['nullable', 'string', Rule::in($shipping_methods)],
            'delivery_address'                 => ['nullable', 'array'],
            'delivery_address.name'            => ['required', 'string'],
            'delivery_address.phone'           => ['required', 'string', 'min:10', 'max:11'],
            'delivery_address.address'         => ['required', 'string'],
            'delivery_address.address_details' => ['required', 'string'],
            'delivery_address.latitude'        => ['required', 'string'],
            'delivery_address.longitude'       => ['required', 'string'],
            'delivery_address.postal_code'     => ['required', 'string'],
        ];
    }
}
