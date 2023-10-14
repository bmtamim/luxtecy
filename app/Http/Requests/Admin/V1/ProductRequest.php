<?php

namespace App\Http\Requests\Admin\V1;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        //When image are updating image should be nullable
        $imageRequiredRule = 'required';
        if ($this->isMethod('PUT')) {
            $imageRequiredRule = 'nullable';
        }

        return [
            'title_en'    => ['required', 'string', 'max:100'],
            'title_cn'    => ['required', 'string', 'max:100'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'max:200'],
            'thumbnail'   => [$imageRequiredRule, 'image', 'mimes:jpg,png,jpeg', 'max:2048'], //2mb
            'label'       => ['nullable', 'string', 'max:25'],
            'category_id' => ['required', 'numeric', 'exists:categories,id'],
        ];
    }
}
