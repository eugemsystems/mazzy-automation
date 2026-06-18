<?php

namespace Webkul\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Webkul\Core\Rules\Code;

class ShippingZoneRequest extends FormRequest
{
    /**
     * Determine if the request is authorized.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Normalise the code into a valid slug, generating it from the name when
     * left blank, so admins are not blocked by the strict code format.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'code' => generate_shipping_code($this->input('code') ?: $this->input('name')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required', 'unique:shipping_zones,code,'.$this->id, new Code],
            'name' => ['required'],
            'base_cost' => ['nullable', 'numeric', 'min:0'],
            'free_qty' => ['nullable', 'numeric', 'min:0'],
            'extra_unit_cost' => ['nullable', 'numeric', 'min:0'],
            'provinces' => ['array'],
            'provinces.*' => ['string'],
            'is_fallback' => ['sometimes'],
            'status' => ['sometimes'],
        ];
    }
}
