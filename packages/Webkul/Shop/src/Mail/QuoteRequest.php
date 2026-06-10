<?php

namespace Webkul\Shop\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class QuoteRequest extends Mailable
{
    public function __construct(public array $quoteData) {}

    public function envelope(): Envelope
    {
        $subject = 'Quote Request';

        if (! empty($this->quoteData['subject'])) {
            $subject = 'Quote Request: '.$this->quoteData['subject'];
        }

        return new Envelope(
            to: [
                new Address(
                    core()->getAdminEmailDetails()['email'],
                    core()->getAdminEmailDetails()['name']
                ),
            ],
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'shop::emails.quote-request',
        );
    }
}
