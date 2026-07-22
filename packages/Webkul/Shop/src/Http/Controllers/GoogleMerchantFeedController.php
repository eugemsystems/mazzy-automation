<?php

namespace Webkul\Shop\Http\Controllers;

use Webkul\Shop\Exports\GoogleMerchantFeedExport;

class GoogleMerchantFeedController extends Controller
{
    /**
     * Stream the Google Shopping product feed CSV, protected by a secret
     * token instead of a login — Google Merchant Center pulls this URL
     * directly on its own schedule.
     */
    public function index(string $token)
    {
        $expectedToken = config('google_merchant.feed_token');

        if (
            ! $expectedToken
            || ! hash_equals($expectedToken, $token)
        ) {
            abort(404);
        }

        return (new GoogleMerchantFeedExport)->download();
    }
}
