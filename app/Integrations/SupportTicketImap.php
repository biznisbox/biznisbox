<?php
namespace App\Integrations;

use DirectoryTree\ImapEngine\Mailbox;
use DirectoryTree\ImapEngine\Message;
use App\Models\SupportTicket;
use App\Models\SupportTicketContent;

class SupportTicketImap
{
    private $config;
    private $imapConnection;
    public function __construct()
    {
        $this->config = settings([
            'support_ticket_imap_available',
            'support_ticket_imap_password',
            'support_ticket_imap_default_folder',
            'support_ticket_imap_host',
            'support_ticket_imap_port',
            'support_ticket_imap_encryption',
            'support_ticket_imap_username',
        ]);
        try {
            $this->initializeImapConnection();
        } catch (\Exception $e) {
            // Handle connection error (e.g., log the error)
            logger()->error('IMAP Connection Error: ' . $e->getMessage());
            saveSystemLog(
                'InitializeSupportTicketImap',
                'error',
                'critical',
                'SupportTicketImap',
                'Failed to initialize IMAP connection: ' . $e->getMessage(),
            );
        }
    }

    private function initializeImapConnection()
    {
        $this->imapConnection = new Mailbox([
            'host' => $this->config['support_ticket_imap_host'],
            'port' => $this->config['support_ticket_imap_port'],
            'encryption' => $this->config['support_ticket_imap_encryption'],
            'username' => $this->config['support_ticket_imap_username'],
            'password' => $this->config['support_ticket_imap_password'],
        ]);
    }

    public function getImapConnection()
    {
        return $this->imapConnection;
    }

    public function getDefaultFolder()
    {
        return $this->config['support_ticket_imap_default_folder'] ?? 'INBOX';
    }

    public function processMessages()
    {
        if (!$this->config['support_ticket_imap_available']) {
            return "Option not enabled";
        }

        try {
            $inbox = $this->imapConnection->inbox();
            $messages = $inbox->messages()->withHeaders()->withFlags()->withBody()->get();

            foreach ($messages as $message) {
                $this->processMessage($message);
                $message->markSeen();
            }
        } catch (\Exception $e) {
            logger()->error('IMAP Processing Error: ' . $e->getMessage());
            saveSystemLog(
                'ProcessSupportTicketImapMessages',
                'error',
                'critical',
                'SupportTicketImap',
                'Failed to process IMAP messages: ' . $e->getMessage(),
            );
        }
    }

    private function processMessage(Message $message)
    {
        // Check if message with same message_id already exists
        $existingContent = SupportTicketContent::where('message_id', $message->messageId())->first();
        if ($existingContent) {
            return;
        }

        // Get ticket id from subject
        $subject = $message->subject();
        // Ticket number is written into [] (extract value between square brackets)
        preg_match('/\[([^\]]+)\]/', $subject, $matches);
        // Existing ticket found
        if (isset($matches[1])) {
            $ticketNumber = $matches[1];
            $ticket = SupportTicket::where('number', $ticketNumber)->first();
            if ($ticket) {
                // Check if message with same message_id already exists
                $this->createTicketContent($ticket->id, $message, $subject);
            }
        } else {
            // No existing ticket found, create new ticket and content
            $newTicket = SupportTicket::create([
                'number' => SupportTicket::getTicketNumber(),
                'subject' => $subject,
                'status' => 'open',
                'priority' => 'medium',
                'source' => 'email',
                'is_internal' => false,
                'contact_name' => $message->from() ? $message->from()->name() : 'Unknown',
                'contact_email' => $message->from() ? $message->from()->email() : null,
                'custom_contact' => true,
                'channel' => 'email',
                'type' => 'ticket',
            ]);
            $this->createTicketContent($newTicket->id, $message, $subject);
            incrementLastItemNumber('support_ticket', settings('support_ticket_number_format'));
        }
    }

    private function createTicketContent($ticketId, Message $message, $subject)
    {
        SupportTicketContent::create([
            'ticket_id' => $ticketId,
            'to' => $message->to() ? implode(', ', array_map(fn($addr) => $addr->name() . ' <' . $addr->email() . '>', $message->to())) : '',
            'from' => $message->from() ? $message->from()->name() . ' <' . $message->from()->email() . '>' : null,
            'status' => 'received',
            'message' => $message->html(),
            'type' => 'text',
            'subject' => $subject,
            'message_id' => $message->messageId(),
        ]);
    }
}
