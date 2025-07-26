<?php

namespace App\Http\Controllers\ClientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientPortal\QuoteService;

/**
 * @group Client Portal Quotes
 *
 * APIs for managing quotes in the client portal
 */
class QuoteController extends Controller
{
    private $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    /**
     * Get all quotes from current logged in user in the client portal
     *
     * @return Quote[] $quotes Quotes
     * @authenticated
     */
    public function getQuotes(Request $request)
    {
        $quotes = $this->quoteService->getQuotes();

        if (!$quotes) {
            return api_response(null, __('responses.item_not_found'), 404);
        }

        return api_response($quotes, __('responses.data_retrieved_successfully'));
    }

    /**
     * Get quote by ID
     *
     * @param  string $quoteId Quote UUID
     * @return Quote $quote Quote
     * @authenticated
     */
    public function getQuoteById(Request $request, $quoteId)
    {
        $quote = $this->quoteService->getQuoteById($quoteId);

        if (!$quote) {
            return api_response(null, __('responses.item_not_found'), 404);
        }

        return api_response($quote, __('responses.data_retrieved_successfully'));
    }
}
