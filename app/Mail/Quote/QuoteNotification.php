<?php

namespace App\Mail\Quote;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $quote;
    protected $url;
    protected $contact;
    /**
     * Create a new message instance.
     */
    public function __construct($quote, $url, $contact = null)
    {
        $this->url = $url;
        $this->quote = $quote;
        $this->contact = $contact;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Quote Notification', tags: ['quote'], metadata: ['quote_id' => $this->quote->id]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.quote.notification',
            with: [
                'quote' => $this->quote,
                'url' => $this->url,
                'contact' => $this->contact,
            ],
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
