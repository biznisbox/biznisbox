<?php

namespace App\Mail\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    private $invoice;
    private $url;
    private $contact;
    private $settings;

    /**
     * Create a new message instance.
     */
    public function __construct($invoice, $url, $contact = null)
    {
        $this->invoice = $invoice;
        $this->url = $url;
        $this->contact = $contact;
        $this->settings = settings([
            'company_name',
            'company_address',
            'company_city',
            'company_zip',
            'company_country',
            'company_phone',
            'company_email',
            'company_vat',
            'company_logo',
            'default_currency',
            'date_format',
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: __('email.subject_new_invoice'), tags: ['invoice'], metadata: ['invoice_id' => $this->invoice->id]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice.notification',
            with: [
                'invoice' => $this->invoice,
                'url' => $this->url,
                'contact' => $this->contact,
                'settings' => $this->settings,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
