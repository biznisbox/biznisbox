<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Client\QuoteService;
/**
 * @group Client Quotes
 *
 * APIs for managing quotes
 */
class QuoteController extends Controller
{
    private $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    /**
     * Get quote by key
     * 
     * @return array $quote Quote
     */
    public function getQuote(Request $request)
    {
        $key = $request->key;
        $quote = $this->quoteService->getQuote($key);

        if (!$quote) {
            return api_response(null, __('responses.item_not_found'), 404);
        }
        return api_response($quote);
    }

    /**
     * Accept or reject quote
     * 
     * @param  object  $request data from the form (key, status)
     * @return array $quote Quote
     */
    public function acceptRejectQuote(Request $request)
    {
        $key = $request->key;
        $status = $request->status;
        $quote = $this->quoteService->acceptRejectQuote($key, $status);

        if (!$quote) {
            return api_response(null, __('responses.item_not_updated'), 400);
        }
        return api_response($quote);
    }
}
