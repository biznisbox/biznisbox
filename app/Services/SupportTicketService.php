<?php

namespace App\Services;

use App\Models\SupportTicket;
use App\Models\SupportTicketContent;

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
}
