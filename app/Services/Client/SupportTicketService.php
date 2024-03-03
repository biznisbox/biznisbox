<?php

namespace App\Services\Client;

use App\Models\SupportTicketContent;
use App\Models\SupportTicket;
use App\Models\ExternalKeys;

class SupportTicketService
{
    /**
     * Get ticket by key
     *
     * @param string $key External key
     * @return void
     */
    public function getTicket($key)
    {
        if (!$key) {
            return api_response(null, __('response.no_key_provided'), 404);
        }

        if (validate_external_key($key, 'support')) {
            $key_data = new ExternalKeys();
            $key_data = $key_data->getExternalKey($key, 'support');
            $ticket = new SupportTicket();
            $ticket = $ticket->getClientTicket($key_data->module_item_id);

            if (!$ticket) {
                return api_response(false, __('response.support_tickets.get_failed'), 400);
            }
            activity_log(
                null,
                'clientGetTicket',
                $key_data->module_item_id,
                'App\Models\SupportTicket',
                'ClientSupportTicket',
                'external',
                $key,
            );
            return api_response($ticket, __('response.support_tickets.get_success'));
        } else {
            return api_response(null, __('response.support_tickets.get_failed'), 400);
        }
    }

    /**
     * Send replay to ticket by key
     *
     * @param string $key External key
     * @param object $data Request data
     * @return response json
     */
    public function clientSendReplay($key, $data)
    {
        if (!$key) {
            return api_response(null, __('response.no_key_provided'), 404);
        }

        if (validate_external_key($key, 'support')) {
            $key_data = new ExternalKeys();
            $key_data = $key_data->getExternalKey($key, 'support');
            $ticket = new SupportTicket();
            $ticket = $ticket->getClientTicket($key_data->module_item_id);

            if (!$ticket) {
                return api_response(false, __('response.support.not_found'), 404);
            }

            $content = [
                'ticket_id' => $ticket->id,
                'type' => 'text',
                'status' => 'sent',
                'from' => $data['from'] ?? null,
                'message' => $data['message'],
            ];

            $reply = SupportTicketContent::create($content);

            if ($reply) {
                activity_log(
                    null,
                    'clientSendReplay',
                    $key_data->module_item_id,
                    'App\Models\SupportTicket',
                    'ClientSupportTicket',
                    'external',
                    $key,
                );
                $ticket = new SupportTicket();
                $ticket = $ticket->getClientTicket($key_data->module_item_id);
                return api_response($ticket, __('response.success'));
            } else {
                return api_response(null, __('response.support.not_found'), 404);
            }
        } else {
            return api_response(null, __('response.support.not_found'), 404);
        }
    }
}
