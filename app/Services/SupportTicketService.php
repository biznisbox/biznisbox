<?php

namespace App\Services;

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
        $tickets = $this->supportTicketModel->getSupportTickets();
        return $tickets;
    }

    public function getTicket($id)
    {
        $ticket = $this->supportTicketModel->getSupportTicket($id);
        return $ticket;
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
        $ticket = $this->supportTicketModel->createSupportTicket($data);
        if ($ticket) {
            return $ticket;
        }
        return false;
    }

    public function updateSupportTicket($id, $data)
    {
        $ticket = $this->supportTicketModel->updateSupportTicket($id, $data);
        if ($ticket) {
            return $ticket;
        }
        return false;
    }

    public function deleteSupportTicket($id)
    {
        $ticket = $this->supportTicketModel->deleteSupportTicket($id);
        if ($ticket) {
            return $ticket;
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

    public function createTicketMessage($ticker_id, $data)
    {
        $supportTicketMessage = $this->supportTicketContentModel->createTicketMessage($ticker_id, $data);
        if ($supportTicketMessage) {
            return $supportTicketMessage;
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
        $ticket = $this->supportTicketModel->getTicketNumber();
        return $ticket;
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
            Mail::to($ticket->contact_email, $ticket->contact_name)->send(
                new \App\Mail\Client\SupportTicketNotification($ticket, $url, null),
            );
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
                Mail::to($contact->email, $contact->name)->send(new \App\Mail\Client\SupportTicketNotification($ticket, $url, $contact));
            }
        }

        createActivityLog('sendSupportTicketNotification', $ticket->id, SupportTicket::$modelName, 'SupportTicket');
        return true;
    }
}
