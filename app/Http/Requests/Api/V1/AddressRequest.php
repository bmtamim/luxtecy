<?php

namespace App\Http\Requests\Api\V1;

use App\Services\Api\V1\PostalCodeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressRequest extends FormRequest
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
        return [
            'user_token'      => ['required', 'string', 'exists:user_sessions,token'],
            'name'            => ['required', 'string'],
            'phone'           => ['nullable', 'string'],
            'address'         => ['nullable', 'string'],
            'address_details' => ['nullable', 'string'],
            'latitude'        => ['nullable', 'string'],
            'longitude'       => ['nullable', 'string'],
            'postal_code'     => ['nullable', 'string', Rule::notIn(PostalCodeService::excluded())],
        ];
    }
}
