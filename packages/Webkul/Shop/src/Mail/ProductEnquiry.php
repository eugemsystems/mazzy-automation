<?php

namespace Webkul\Shop\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ProductEnquiry extends Mailable
{
    public function __construct(public array $enquiryData) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [
                new Address(
                    core()->getAdminEmailDetails()['email'],
                    core()->getAdminEmailDetails()['name']
                ),
            ],
            subject: 'Product Enquiry: '.$this->enquiryData['product_name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'shop::emails.product-enquiry',
        );
    }
}
