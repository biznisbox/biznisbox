<?php

namespace App\Mail\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ClientPortalNotification extends Mailable
{
    use Queueable, SerializesModels;

    private $partner;
    private $partnerContact;
    private $password;

    /**
     * Create a new message instance.
     */
    public function __construct($partner, $password, $partnerContact = null)
    {
        $this->partnerContact = $partnerContact;
        $this->partner = $partner;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('email.client_portal_notification_subject'),
            metadata: [
                'partner_id' => $this->partner->id,
                'partner_contact_id' => $this->partnerContact ? $this->partnerContact->id : null,
                'partner_contact_email' => $this->partnerContact ? $this->partnerContact->email : null,
            ],
            tags: ['ClientPortalNotification']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.client_portal.notification',
            with: [
                'partner' => $this->partner,
                'partner_contact' => $this->partnerContact,
                'password' => $this->password,
                'url' => url('/auth/login?redirect=/client-portal'),
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
