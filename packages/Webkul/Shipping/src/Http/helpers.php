<?php

use Illuminate\Support\Str;
use Webkul\Shipping\Facades\Shipping;

if (! function_exists('generate_shipping_code')) {
    /**
     * Turn any human entered text into a valid Bagisto "code" slug: starts
     * with a letter, then letters/digits/underscores only. Used by the
     * shipping CRUDs so admins can type freely (or leave the code blank).
     *
     * @param  string|null  $value
     * @return string
     */
    function generate_shipping_code($value)
    {
        $code = Str::slug((string) $value, '_');

        if ($code === '' || ! preg_match('/^[a-zA-Z]/', $code)) {
            $code = 'sc_'.$code;
        }

        return trim($code, '_');
    }
}

if (! function_exists('shipping')) {
    /**
     * Shipping helper.
     *
     * @return Webkul\Shipping\Shipping
     */
    function shipping()
    {
        return Shipping::getFacadeRoot();
    }
}
