<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuoteService;
use App\Http\Requests\QuoteRequest;

/**
 * @group Quotes
 *
 * APIs for managing quotes
 * @authenticated
 */
class QuoteController extends Controller
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    /**
     * Get all quotes
     *
     * @return array $quotes Quotes
     */
    public function getQuotes()
    {
        $quotes = $this->quoteService->getQuotes();

        if ($quotes) {
            return apiResponse($quotes, __('responses.data_retrieved_successfully'));
        }
        return apiResponse(null, __('responses.item_not_found'), 404);
    }

    /**
     * Get quote by id
     *
     * @param  string  $id id of the quote
     * @return array $quote Quote
     */
    public function getQuote($id)
    {
        $quote = $this->quoteService->getQuote($id);

        if ($quote) {
            return apiResponse($quote, __('responses.data_retrieved_successfully'));
        }
        return apiResponse(null, __('responses.item_not_found_with_id'), 404);
    }

    /**
     * Create a new quote
     *
     * @param  object  $request data from the form
     * @return array $quote Quote
     */
    public function createQuote(QuoteRequest $request)
    {
        $data = $request->all();
        $quote = $this->quoteService->createQuote($data);
        if ($quote) {
            return apiResponse($quote, __('responses.item_created_successfully'));
        }
        return apiResponse(null, __('responses.item_not_created'), 400);
    }

    /**
     * Update a quote
     *
     * @param  object  $request data from the form
     * @param  string  $id id of the quote
     * @return array $quote Quote
     */
    public function updateQuote(QuoteRequest $request, $id)
    {
        $data = $request->all();
        $quote = $this->quoteService->updateQuote($id, $data);
        if ($quote) {
            return apiResponse($quote, __('responses.item_updated_successfully'));
        }
        return apiResponse(null, __('responses.item_not_updated'), 400);
    }

    /**
     * Delete a quote
     *
     * @param  string  $id id of the quote
     * @return array $quote Quote
     */
    public function deleteQuote($id)
    {
        $quote = $this->quoteService->deleteQuote($id);
        if ($quote) {
            return apiResponse($quote, __('responses.item_deleted_successfully'));
        }
        return apiResponse(null, __('responses.item_not_deleted'), 400);
    }

    /**
     * Get quote number
     *
     * @return array $number Quote number
     */
    public function getQuoteNumber()
    {
        $number = $this->quoteService->getQuoteNumber();
        if ($number) {
            return apiResponse($number, __('responses.data_retrieved_successfully'));
        }
        return apiResponse(null, __('responses.error_occurred'), 400);
    }

    /**
     * Share a quote
     *
     * @param  string $id id of the quote
     * @return array $quote Quote
     */
    public function shareQuote($id)
    {
        $quote = $this->quoteService->shareQuote($id);
        if ($quote) {
            return apiResponse($quote, __('responses.item_shared_successfully'));
        }
        return apiResponse(null, __('responses.item_not_shared'), 400);
    }

    /**
     * Convert a quote to invoice
     *
     * @param  string $id id of the quote
     * @return array $invoice Invoice
     */
    public function convertQuoteToInvoice($id)
    {
        $invoice = $this->quoteService->convertQuoteToInvoice($id);
        if ($invoice) {
            return apiResponse($invoice, __('responses.item_converted_successfully'));
        }
        return apiResponse(null, __('responses.item_not_converted'), 400);
    }

    /**
     * Get quote pdf
     *
     * @param  object  $request data from the form
     * @param  string  $id id of the quote
     * @return array $quote Quote
     */
    public function getQuotePdf(Request $request, $id)
    {
        if (!$request->hasValidSignatureWhileIgnoring(['lang'])) {
            return apiResponse(null, __('responses.invalid_signature'), 400);
        }
        $type = $request->input('type', 'stream');
        return $this->quoteService->getQuotePdf($id, $type);
    }

    /**
     * Send quote notification
     *
     * @param  object  $request data from the form
     * @param  string  $id id of the quote
     * @return array $quote_notification Quote notification
     */
    public function sendQuoteNotification(Request $request, $id)
    {
        if ($request->has('contact')) {
            $contact = $request->input('contact');
        } else {
            $contact = null;
        }
        $quote_notification = $this->quoteService->sendQuoteNotification($id, $contact);
        if (!$quote_notification) {
            return apiResponse(null, __('responses.notification_not_sent'), 400);
        }
        return apiResponse($quote_notification, __('responses.notification_sent_successfully'));
    }
}
