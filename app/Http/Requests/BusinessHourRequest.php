<?php

namespace App\Http\Requests;

use App\Rules\BusinessHourException;
use App\Rules\BusinessHourTime;
use Illuminate\Foundation\Http\FormRequest;

class BusinessHourRequest extends FormRequest
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
            'monday'       => ['nullable', 'array', new BusinessHourTime],
            'tuesday'      => ['nullable', 'array', new BusinessHourTime],
            'wednesday'    => ['nullable', 'array', new BusinessHourTime],
            'thursday'     => ['nullable', 'array', new BusinessHourTime],
            'friday'       => ['nullable', 'array', new BusinessHourTime],
            'saturday'     => ['nullable', 'array', new BusinessHourTime],
            'sunday'       => ['nullable', 'array', new BusinessHourTime],
            'exceptions'   => ['nullable', 'array', new BusinessHourException],
            'exceptions.*' => ['nullable', 'array', new BusinessHourTime],
        ];
    }
}
