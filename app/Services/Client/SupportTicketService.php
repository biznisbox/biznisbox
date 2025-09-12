<?php

namespace App\Services\Client;

use App\Models\SupportTicket;
use App\Models\SupportTicketContent;
use App\Models\ExternalKey;
use Illuminate\Support\Str;

class SupportTicketService
{
    public function getTicket($key)
    {
        if (!$key) {
            return null;
        }

        if (validateExternalKey($key, 'support')) {
            $key_data = ExternalKey::getExternalKey($key, 'support');
            $ticket = SupportTicket::getClientTicket($key_data->module_item_id);

            if (!$ticket) {
                return false;
            }
            return $ticket;
        } else {
            return false;
        }
    }

    public function replayOnTicket($key, $data)
    {
        if (!$key) {
            return null;
        }

        if (validateExternalKey($key, 'support')) {
            $key_data = ExternalKey::getExternalKey($key, 'support');
            $ticket = SupportTicket::find($key_data->module_item_id);
            if (!$ticket) {
                return false;
            }
            $content = new SupportTicketContent();

            $response = [
                'from' => $data['from'] ?? ($key_data->recipient_id ?? 'Client'),
                'message' => $data['message'],
            ];

            $content = $content->createTicketMessage($ticket->id, $response);
            if ($content) {
                createNotification(
                    getUserIdFromEmployeeId($ticket->assignee_id),
                    'NewTicketMessage',
                    Str::limit($data['message'], 150),
                    'info',
                    'view',
                    'support/' . $ticket->id,
                );
                return $content;
            }
            return false;
        } else {
            return false;
        }
    }
}
