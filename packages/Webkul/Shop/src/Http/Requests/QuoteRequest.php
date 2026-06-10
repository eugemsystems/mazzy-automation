<?php

namespace Webkul\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Webkul\Core\Rules\PhoneNumber;

class QuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => ['nullable', new PhoneNumber],
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ];
    }
}
