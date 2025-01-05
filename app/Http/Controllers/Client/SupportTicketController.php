<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Client\SupportTicketService;

/**
 * @group Client Support Tickets
 *
 * APIs for managing support tickets
 */
class SupportTicketController extends Controller
{
    private $supportTicketService;

    public function __construct(SupportTicketService $supportTicketService)
    {
        $this->supportTicketService = $supportTicketService;
    }


    /**
     * Get ticket by key
     * 
     * @param  object  $request data from the form (key)
     * @return array $ticket ticket
     */
    public function getTicket(Request $request)
    {
        $key = $request->get('key');
        $ticket = $this->supportTicketService->getTicket($key);
        if ($ticket) {
            return api_response($ticket, __('responses.data_retrieved_successfully'));
        }
        return api_response(null, __('responses.item_not_found'), 404);
    }

    /**
     * Reply on ticket
     * 
     * @param  object  $request request data
     * @return array $ticket ticket
     */
    public function replayOnTicket(Request $request)
    {
        $data = $request->all();
        $key = $request->get('key');
        $content = $this->supportTicketService->replayOnTicket($key, $data);
        if ($content) {
            return api_response($content, __('responses.item_updated_successfully'));
        }
        return api_response(null, __('responses.item_not_updated'), 400);
    }
}
