<?php

namespace App\Mail\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class EstimateNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $estimate = null;
    public $pdf = null;
    public $link = null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($estimate, $link, $pdf)
    {
        $this->estimate = $estimate;
        $this->pdf = $pdf;
        $this->link = $link;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: __('pdf.estimate.title') . ' ' . $this->estimate->number,
            metadata: [
                'estimate_id' => $this->estimate->id,
            ],
            tags: ['estimate', 'customer']
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.customer.estimate_notification',
            with: [
                'estimate' => $this->estimate,
                'link' => $this->link,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [
            Attachment::fromData(fn() => $this->pdf, __('pdf.estimate.title') . ' ' . $this->estimate->number . '.pdf')->withMime(
                'application/pdf'
            ),
        ];
    }
}
