<?php

namespace App\Services\ClientPortal;

use App\Models\SupportTicket;
use App\Models\User;

class SupportTicketService
{
    public function getTickets()
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        $tickets = SupportTicket::where('partner_id', $partner_id)->get();
        createActivityLog('retrieve', null, SupportTicket::$modelName, 'SupportTicket', auth()->id(), User::$modelName, 'client_portal');
        return $tickets;
    }

    public function getTicketById($ticketId)
    {
        $partner_id = getPartnerIdFromUserId(auth()->id());

        $ticket = SupportTicket::with(['contents', 'partnerContact'])
            ->where('id', $ticketId)
            ->where('partner_id', $partner_id)
            ->first();

        createActivityLog('retrieve', $ticketId, SupportTicket::$modelName, 'Support Ticket', auth()->id(), User::$modelName, 'client_portal');
        return $ticket;
    }
}