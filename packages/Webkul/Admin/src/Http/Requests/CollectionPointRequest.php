<?php

namespace Webkul\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Webkul\Core\Rules\Code;

class CollectionPointRequest extends FormRequest
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
            'code' => ['required', 'unique:collection_points,code,'.$this->id, new Code],
            'name' => ['required'],
            'description' => ['nullable'],
            'country' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
            'street' => ['required'],
            'postcode' => ['required'],
            'contact_number' => ['nullable'],
            'handling_fee' => ['required', 'numeric', 'min:0'],
            'status' => ['sometimes'],
        ];
    }
}
