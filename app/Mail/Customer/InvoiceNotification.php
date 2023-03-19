<?php

namespace App\Mail\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class InvoiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice = null;
    public $pdf = null;
    public $link = null;

    /**
     * Create a new message instance.
     * @param $invoice object
     * @param $link string
     * @param $pdf string
     * @return void
     */
    public function __construct($invoice, $link, $pdf)
    {
        $this->invoice = $invoice;
        $this->pdf = $pdf;
        $this->link = $link;
    }

    /**
     * Get the message envelope.
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: __('pdf.invoice.title') . ' ' . $this->invoice->number,
            metadata: [
                'invoice_id' => $this->invoice->id,
            ],
            tags: ['invoice', 'customer']
        );
    }

    /**
     * Get the message content definition.
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.customer.invoice_notification',
            with: [
                'invoice' => $this->invoice,
                'link' => $this->link,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     * @return array
     */
    public function attachments()
    {
        return [
            Attachment::fromData(fn() => $this->pdf, __('pdf.invoice.title') . ' ' . $this->invoice->number . '.pdf')->withMime(
                'application/pdf'
            ),
        ];
    }
}
