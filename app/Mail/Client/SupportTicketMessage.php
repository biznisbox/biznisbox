<?php

namespace App\Mail\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Symfony\Component\Mime\Email;

class SupportTicketMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $fromName = '';
    public $toEmail = '';
    public $toName = '';
    public $contentMessage;
    public $ticketSubject;
    public $ticketNumber;
    public $ticketId;
    public $messageId;

    /**
     * Create a new message instance.
     * @param string $ticket_subject
     * @param string $ticket_id
     * @param string $fromName
     * @param string $to
     * @param string $content_message
     */
    public function __construct($ticketSubject, $ticketId, $ticketNumber, $fromName, $to, $toName, $contentMessage, $messageId = null)
    {
        $this->fromName = $fromName;
        $this->toEmail = $to;
        $this->toName = $toName;
        $this->ticketSubject = $ticketSubject;
        $this->ticketId = $ticketId;
        $this->ticketNumber = $ticketNumber;
        $this->contentMessage = $contentMessage;
        $this->messageId = $messageId;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(settings('mail_from_address'), $this->fromName),
            subject: '[' . $this->ticketNumber . '] ' . $this->ticketSubject,
            metadata: ['ticket_id' => $this->ticketId],
            to: [new Address($this->toEmail, $this->toName)],
            replyTo: [new Address(settings('support_ticket_imap_username'), $this->fromName)],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.support_ticket.message',
            with: [
                'contentMessage' => $this->contentMessage,
                'ticketId' => $this->ticketId,
                'ticketNumber' => $this->ticketNumber,
                'ticketSubject' => $this->ticketSubject,
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

    public function build()
    {
        if ($this->messageId) {
            $this->addInReplyToHeader();
        }
    }

    private function addInReplyToHeader()
    {
        $this->withSymfonyMessage(function (Email $email) {
            $email->getHeaders()->addTextHeader('In-Reply-To', "<{$this->messageId}>");

            $email->getHeaders()->addTextHeader('References', "<{$this->messageId}>");
        });
    }
}
