<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;

class SupportTicketController extends Controller
{
    protected $supportTicketModel;

    public function __construct(SupportTicket $supportTicketModel)
    {
        $this->supportTicketModel = $supportTicketModel;
    }

    public function getSupportTickets()
    {
        $supportTickets = $this->supportTicketModel->getSupportTickets();

        if ($supportTickets) {
            return api_response($supportTickets, __('response.support_ticket.get_success'));
        }
        return api_response(null, __('response.support_ticket.get_failed'), 400);
    }

    public function getSupportTicket($id)
    {
        $supportTicket = $this->supportTicketModel->getSupportTicket($id);

        if ($supportTicket) {
            return api_response($supportTicket, __('response.support_ticket.get_success'));
        }
        return api_response(null, __('response.support_ticket.not_found'), 404);
    }

    public function createSupportTicket(Request $request)
    {
        $data = $request->all();
        $supportTicket = $this->supportTicketModel->createSupportTicket($data);

        if ($supportTicket) {
            return api_response($supportTicket, __('response.support_ticket.create_success'), 201);
        }
        return api_response(null, __('response.support_ticket.create_failed'), 400);
    }

    public function updateSupportTicket(Request $request, $id)
    {
        $data = $request->all();
        $supportTicket = $this->supportTicketModel->updateSupportTicket($id, $data);

        if ($supportTicket) {
            return api_response($supportTicket, __('response.support_ticket.update_success'));
        }
        return api_response(null, __('response.support_ticket.update_failed'), 400);
    }

    public function deleteSupportTicket($id)
    {
        $supportTicket = $this->supportTicketModel->deleteSupportTicket($id);

        if ($supportTicket) {
            return api_response($supportTicket, __('response.support_ticket.delete_success'));
        }
        return api_response(null, __('response.support_ticket.delete_failed'), 400);
    }

    public function getSupportTicketMessages($id)
    {
        $supportTicketMessages = $this->supportTicketModel->getSupportTicketMessages($id);

        if ($supportTicketMessages) {
            return api_response($supportTicketMessages, __('response.support_ticket_message.get_success'));
        }
        return api_response(null, __('response.support_ticket_message.get_failed'), 400);
    }

    public function createSupportTicketMessage(Request $request, $id)
    {
        $data = $request->all();
        $supportTicketMessage = $this->supportTicketModel->createSupportTicketMessage($id, $data);

        if ($supportTicketMessage) {
            return api_response($supportTicketMessage, __('response.support_ticket_message.create_success'), 201);
        }
        return api_response(null, __('response.support_ticket_message.create_failed'), 400);
    }

    public function updateSupportTicketMessage(Request $request, $id)
    {
        $data = $request->all();
        $supportTicketMessage = $this->supportTicketModel->updateSupportTicketMessage($id, $data);

        if ($supportTicketMessage) {
            return api_response($supportTicketMessage, __('response.support_ticket_message.update_success'));
        }
        return api_response(null, __('response.support_ticket_message.update_failed'), 400);
    }

    public function deleteSupportTicketMessage($id)
    {
        $supportTicketMessage = $this->supportTicketModel->deleteSupportTicketMessage($id);

        if ($supportTicketMessage) {
            return api_response($supportTicketMessage, __('response.support_ticket_message.delete_success'));
        }
        return api_response(null, __('response.support_ticket_message.delete_failed'), 400);
    }

    public function getSupportTicketNumber()
    {
        $supportTicket = $this->supportTicketModel->getSupportTicketNumber();
        if ($supportTicket) {
            return api_response($supportTicket, __('response.support_ticket.get_number_success'));
        }
        return api_response(null, __('response.support_ticket.get_number_failed'), 400);
    }

    public function shareSupportTicket($id)
    {
        $ticket_link = $this->supportTicketModel->shareSupportTicket($id);
        if (!$ticket_link) {
            return api_response(null, __('response.support_ticket.share_failed'), 400);
        }
        return api_response($ticket_link, __('response.support_ticket.share_success'), 200);
    }
}
