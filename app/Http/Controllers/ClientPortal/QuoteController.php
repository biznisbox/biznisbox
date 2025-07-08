<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientPortal\QuoteService;

class QuoteController extends Controller
{
    private $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function getQuotes(Request $request)
    {
        $quotes = $this->quoteService->getQuotes();

        if (!$quotes) {
            return api_response(null, __('responses.item_not_found'), 404);
        }

        return api_response($quotes, __('responses.data_retrieved_successfully'));
    }

    public function getQuoteById(Request $request, $quoteId)
    {
        $quote = $this->quoteService->getQuoteById($quoteId);

        if (!$quote) {
            return api_response(null, __('responses.item_not_found'), 404);
        }

        return api_response($quote, __('responses.data_retrieved_successfully'));
    }
}
