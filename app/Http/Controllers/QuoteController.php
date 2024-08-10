<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuoteService;
use App\Http\Requests\QuoteRequest;

class QuoteController extends Controller
{
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function getQuotes()
    {
        $quotes = $this->quoteService->getQuotes();

        if ($quotes) {
            return api_response($quotes, __('responses.data_retrieved_successfully'));
        }
        return api_response(null, __('responses.item_not_found'), 404);
    }

    public function getQuote($id)
    {
        $quote = $this->quoteService->getQuote($id);

        if ($quote) {
            return api_response($quote, __('responses.data_retrieved_successfully'));
        }
        return api_response(null, __('responses.item_not_found_with_id'), 404);
    }

    public function createQuote(QuoteRequest $request)
    {
        $data = $request->all();
        $quote = $this->quoteService->createQuote($data);
        if ($quote) {
            return api_response($quote, __('responses.item_created_successfully'));
        }
        return api_response(null, __('responses.item_not_created'), 400);
    }

    public function updateQuote(QuoteRequest $request, $id)
    {
        $data = $request->all();
        $quote = $this->quoteService->updateQuote($id, $data);
        if ($quote) {
            return api_response($quote, __('responses.item_updated_successfully'));
        }
        return api_response(null, __('responses.item_not_updated'), 400);
    }

    public function deleteQuote($id)
    {
        $quote = $this->quoteService->deleteQuote($id);
        if ($quote) {
            return api_response($quote, __('responses.item_deleted_successfully'));
        }
        return api_response(null, __('responses.item_not_deleted'), 400);
    }

    public function getQuoteNumber()
    {
        $number = $this->quoteService->getQuoteNumber();
        if ($number) {
            return api_response($number, __('responses.data_retrieved_successfully'));
        }
        return api_response(null, __('responses.error_occurred'), 400);
    }

    public function shareQuote($id)
    {
        $quote = $this->quoteService->shareQuote($id);
        if ($quote) {
            return api_response($quote, __('responses.item_shared_successfully'));
        }
        return api_response(null, __('responses.item_not_shared'), 400);
    }

    public function convertQuoteToInvoice($id)
    {
        $invoice = $this->quoteService->convertQuoteToInvoice($id);
        if ($invoice) {
            return api_response($invoice, __('responses.item_converted_successfully'));
        }
        return api_response(null, __('responses.item_not_converted'), 400);
    }

    public function getQuotePdf(Request $request, $id)
    {
        $type = $request->input('type', 'stream');
        $pdf = $this->quoteService->getQuotePdf($id, $type);
        return $pdf;
    }

    public function sendQuoteNotification(Request $request, $id)
    {
        if ($request->has('contact')) {
            $contact = $request->input('contact');
        } else {
            $contact = null;
        }
        $quote_notification = $this->quoteService->sendQuoteNotification($id, $contact);
        if (!$quote_notification) {
            return api_response(null, __('responses.notification_not_sent'), 400);
        }
        return api_response($quote_notification, __('responses.notification_sent_successfully'));
    }
}
