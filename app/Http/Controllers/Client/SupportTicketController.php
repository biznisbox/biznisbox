<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Client\SupportTicketService;

class SupportTicketController extends Controller
{
    protected $supportTicketService;
    public function __construct(SupportTicketService $supportTicketService)
    {
        $this->supportTicketService = $supportTicketService;
    }

    public function getTicket(Request $request)
    {
        $key = $request->key;
        return $this->supportTicketService->getTicket($key);
    }

    public function clientSendReplay(Request $request)
    {
        $key = $request->key;
        $data = $request->all();
        return $this->supportTicketService->clientSendReplay($key, $data);
    }
}
