<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Client\QuoteService;

class QuoteController extends Controller
{
    protected $quoteService;
    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function getQuote(Request $request)
    {
        $key = $request->key;
        return $this->quoteService->getQuote($key);
    }

    public function acceptRejectQuote(Request $request)
    {
        $key = $request->key;
        $data = $request->status;
        return $this->quoteService->acceptRejectQuote($key, $data);
    }
}
