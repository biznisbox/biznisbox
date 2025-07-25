<?php

namespace App\Mail\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportTicketNotification extends Mailable
{
    use Queueable, SerializesModels;

    private $ticket;
    private $url;
    private $contact;
    /**
     * Create a new message instance.
     */
    public function __construct($ticket, $url, $contact)
    {
        $this->ticket = $ticket;
        $this->url = $url;
        $this->contact = $contact;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('email.subject_support_ticket'),
            tags: ['support_ticket'],
            metadata: ['support_ticket_id' => $this->ticket->id],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.support_ticket.notification',
            with: [
                'ticket' => $this->ticket,
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
