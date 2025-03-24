<?php

namespace App\Mail\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class SendPartnerMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $from_email = '';
    public $from_name = '';
    public $subject;
    private $content_message;

    /**
     * Create a new message instance.
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $content_message
     */
    public function __construct($from_email, $from_name, $subject, $content_message)
    {
        $this->from_email = $from_email;
        $this->from_name = $from_name;
        $this->subject = $subject;
        $this->content_message = $content_message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(from: new Address($this->from_email, $this->from_name), subject: $this->subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(view: 'emails.partner_email', with: ['content_message' => $this->content_message]);
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
