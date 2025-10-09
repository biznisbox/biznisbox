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

    public $fromEmail = '';
    public $fromName = '';
    public $subject;
    private $contentMessage;

    /**
     * Create a new message instance.
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $content_message
     */
    public function __construct($fromEmail, $fromName, $subject, $contentMessage)
    {
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
        $this->subject = $subject;
        $this->contentMessage = $contentMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(from: new Address($this->fromEmail, $this->fromName), subject: $this->subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(view: 'emails.partner_email', with: ['contentMessage' => $this->contentMessage]);
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
