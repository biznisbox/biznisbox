<?php

namespace App\Services;

use App\Mail\Client\SupportTicketMessage;
use App\Models\SupportTicket;
use App\Models\SupportTicketContent;
use App\Models\PartnerContact;
use Illuminate\Support\Facades\Mail;
use App\Mail\Client\SupportTicketNotification;

class SupportTicketService
{
    private $supportTicketModel;
    private $supportTicketContentModel;

    public function __construct()
    {
        $this->supportTicketModel = new SupportTicket();
        $this->supportTicketContentModel = new SupportTicketContent();
    }

    public function getTickets()
    {
        $supportTickets = $this->supportTicketModel
            ->with('assignee:id,first_name,last_name,email', 'partner', 'category', 'content')
            ->get();
        if ($supportTickets) {
            createActivityLog('retrieve', null, SupportTicket::$modelName, 'getSupportTickets');
            return $supportTickets;
        }
        return false;
    }

    public function getTicket($id)
    {
        $supportTicket = $this->supportTicketModel
            ->with('assignee:id,first_name,last_name,email,department_id,position,user_id', 'partner', 'category', 'content')
            ->find($id);
        if ($supportTicket) {
            createActivityLog('retrieve', $id, SupportTicket::$modelName, 'getSupportTicket');
            return $supportTicket;
        }
        return false;
    }

    public function getTicketContents($id)
    {
        $ticket = $this->supportTicketModel->getSupportTicket($id);
        if ($ticket) {
            return $ticket->contents;
        }
        return false;
    }

    public function createTicket($data)
    {
        $data['number'] = $this->supportTicketModel->getTicketNumber();

        $supportTicket = $this->supportTicketModel->create($data);

        if (isset($data['content'])) {
            foreach ($data['content'] as $content) {
                if ($content['message'] == null) {
                    continue;
                }
                $content['ticket_id'] = $supportTicket->id;
                $content['type'] = 'text';
                $content['status'] = 'sent';
                $content['from'] =
                    $content['from'] ?? auth()->user()->first_name . ' ' . auth()->user()->last_name . ' <' . auth()->user()->email . '>';
                $content['message'] = $content['message'];
                $supportTicketMessage = $this->supportTicketContentModel->create($content);
            }
        }

        if ($supportTicket) {
            $this->sendTicketMessage(
                $supportTicket->id,
                $supportTicketMessage->id,
                $supportTicket->custom_contact,
                $supportTicket->contact_id,
                $data,
            );
            incrementLastItemNumber('support_ticket', settings('support_ticket_number_format'));
            sendWebhookForEvent('support_ticket:created', $supportTicket->toArray());
            return $supportTicket;
        }
        return false;
    }

    public function updateSupportTicket($id, $data)
    {
        $supportTicket = $this->supportTicketModel->find($id);

        if (isset($data['status']) && $data['status'] == 'closed') {
            $this->supportTicketModel->generateSystemMessage($id, 'This ticket has been closed');
        }

        if (isset($data['status']) && $data['status'] == 'reopened') {
            $this->supportTicketModel->generateSystemMessage($id, 'This ticket has been reopened');
        }

        if (isset($data['status']) && $data['status'] == 'resolved') {
            $this->supportTicketModel->generateSystemMessage($id, 'This ticket has been resolved');
        }

        // Clear contact details if custom contact is true
        if ($data['custom_contact']) {
            $data['contact_id'] = null;
            $data['partner_id'] = null;
        }

        // Clear custom contact details if custom contact is false
        if (!$data['custom_contact']) {
            $data['contact_name'] = null;
            $data['contact_email'] = null;
            $data['contact_phone_number'] = null;
        }

        $data['number'] = $supportTicket['number'];

        $supportTicket->update($data);

        if ($supportTicket) {
            $supportTicket = $this->supportTicketModel->getSupportTicket($id);
            sendWebhookForEvent('support_ticket:updated', $supportTicket->toArray());
            return $supportTicket;
        }
        return false;
    }

    public function deleteSupportTicket($id)
    {
        $supportTicket = $this->supportTicketModel->find($id);
        $supportTicket->delete();

        if ($supportTicket) {
            sendWebhookForEvent('support_ticket:deleted', $supportTicket->toArray());
            return $supportTicket;
        }
        return false;
    }

    public function getTicketMessages($id)
    {
        $ticket = $this->supportTicketContentModel->getTicketMessages($id);
        if ($ticket) {
            return $ticket;
        }
        return false;
    }

    public function createTicketMessage($ticket_id, $data)
    {
        // Get ticket to verify it exists
        $ticket = $this->getTicket($ticket_id);
        if (!$ticket) {
            return false;
        }
        $message = $this->supportTicketContentModel->create([
            'ticket_id' => $ticket_id,
            'to' => $data['to'] ?? null,
            'from' => $data['from'] ?? auth()->user()->first_name . ' ' . auth()->user()->last_name . ' <' . auth()->user()->email . '>',
            'message' => $data['message'],
            'type' => 'text',
            'status' => 'sent',
        ]);

        if ($message) {
            $this->sendTicketMessage($ticket_id, $message->id, $ticket->custom_contact, $ticket->contact_id, $data);
            sendWebhookForEvent('support_ticket:new_message', [array_merge($message->toArray(), ['ticket_id' => $ticket_id])]);
            return $this->getTicket($ticket_id);
        }
        return false;
    }

    public function updateTicketMessage($id, $data)
    {
        $supportTicketMessage = $this->supportTicketContentModel->updateTicketMessage($id, $data);
        if ($supportTicketMessage) {
            return $supportTicketMessage;
        }
        return false;
    }

    public function deleteTicketMessage($id)
    {
        $supportTicketMessage = $this->supportTicketContentModel->deleteTicketMessage($id);
        if ($supportTicketMessage) {
            return $supportTicketMessage;
        }

        return false;
    }

    public function getTicketNumber()
    {
        return $this->supportTicketModel->getTicketNumber();
    }

    public function shareTicket($id)
    {
        $ticket = $this->supportTicketModel->shareTicket($id);
        if ($ticket) {
            return $ticket;
        }
        return false;
    }

    public function sendTicketNotificationToContact($id)
    {
        $ticket = $this->supportTicketModel->getClientTicket($id);

        if ($ticket->is_internal == true) {
            return false;
        }

        if ($ticket->custom_contact) {
            $url = url(
                '/client/support/' .
                    $ticket->id .
                    '?key=' .
                    generateExternalKey('support', $ticket->id, 'system', null, $ticket->contact_email, 'email') .
                    '&lang=' .
                    app()->getLocale(),
            );

            setEmailConfig();
            Mail::to($ticket->contact_email, $ticket->contact_name)->send(new SupportTicketNotification($ticket, $url, null));
            saveSendEmailLog('SupportTicketNotification', 'support_ticket', $ticket->contact_email, 'sent', 'user', auth()->id());
            return true;
        } else {
            $contacts = PartnerContact::where('id', $ticket->contact_id)->whereNotNull('email')->get();

            foreach ($contacts as $contact) {
                $url = url(
                    '/client/support/' .
                        $ticket->id .
                        '?key=' .
                        generateExternalKey('support', $ticket->id, 'system', null, $contact->email, 'email') .
                        '&lang=' .
                        app()->getLocale(),
                );

                setEmailConfig();
                Mail::to($contact->email, $contact->name)->send(new SupportTicketNotification($ticket, $url, $contact));
                saveSendEmailLog('SupportTicketNotification', 'support_ticket', $contact->email, 'sent', 'user', auth()->id());
            }
        }

        createActivityLog('sendSupportTicketNotification', $ticket->id, SupportTicket::$modelName, 'SupportTicket');
        return true;
    }

    public function sendTicketMessage($ticket_id, $contentId, $customContact, $contactId, $data = [])
    {
        if (!settings('support_ticket_imap_available')) {
            return;
        }
        $ticket = $this->getTicket($ticket_id);

        if ($ticket->is_internal == true) {
            return false;
        }

        $messageContent = $this->supportTicketContentModel->getTicketMessageById($contentId);

        // select latest replay for response threading
        $latestContent = SupportTicketContent::where('ticket_id', $ticket_id)
            ->whereNotNull('message_id')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($customContact) {
            $contact = new \stdClass();
            $contact->email = $ticket->contact_email;
            $contact->name = $ticket->contact_name;
        } else {
            $contact = PartnerContact::find($contactId);
        }

        if (!$ticket || !$contact) {
            return false;
        }

        setEmailConfig();
        Mail::to($contact->email, $contact->name)->send(
            new SupportTicketMessage(
                $ticket->subject,
                $ticket->id,
                $ticket->number,
                auth()->user()->first_name . ' ' . auth()->user()->last_name,
                $contact->email,
                $contact->name,
                $messageContent->message,
                $latestContent ? $latestContent->message_id : null,
            ),
        );
        saveSendEmailLog(
            'SupportTicketMessage',
            'support_ticket',
            $contact->email,
            'sent',
            'user',
            auth()->id(),
            $ticket->subject,
            $messageContent->message,
        );

        return true;
    }
}
