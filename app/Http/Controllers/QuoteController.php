<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
class QuoteController extends Controller
{
    protected $quoteModel;
    public function __construct(Quote $quoteModel)
    {
        $this->quoteModel = $quoteModel;
    }

    public function getQuotes()
    {
        $quotes = $this->quoteModel->getQuotes();

        if (!$quotes) {
            return api_response(null, __('response.quote.get_error'), 500);
        }
        return api_response($quotes, __('response.quote.get_success'));
    }

    public function getQuote($id)
    {
        $quote = $this->quoteModel->getQuote($id);

        if (!$quote) {
            return api_response(null, __('response.quote.not_found'), 500);
        }
        return api_response($quote, __('response.quote.get_success'));
    }

    public function createQuote(Request $request)
    {
        $quoteData = $request->all();
        $quote = $this->quoteModel->createQuote($quoteData);

        if (!$quote) {
            return api_response(null, __('response.quote.create_failed'), 500);
        }
        return api_response($quote, __('response.quote.create_success'), 201);
    }

    public function updateQuote(Request $request, $id)
    {
        $quoteData = $request->all();
        $quote = $this->quoteModel->updateQuote($id, $quoteData);

        if (!$quote) {
            return api_response(null, __('response.quote.update_failed'), 500);
        }
        return api_response($quote, __('response.quote.update_success'));
    }

    public function deleteQuote($id)
    {
        $quote = $this->quoteModel->deleteQuote($id);

        if (!$quote) {
            return api_response(null, __('response.quote.delete_failed'), 500);
        }
        return api_response($quote, __('response.quote.delete_success'));
    }

    public function getQuoteNumber()
    {
        $quote_number = $this->quoteModel->getQuoteNumber();

        if (!$quote_number) {
            return api_response(null, __('response.quote.number_error'), 500);
        }
        return api_response($quote_number, __('response.quote.number_success'));
    }

    public function convertQuoteToInvoice($id)
    {
        $invoice = $this->quoteModel->convertQuoteToInvoice($id);

        if (!$invoice) {
            return api_response(null, __('response.quote.convert_failed'), 500);
        }
        return api_response($invoice, __('response.quote.convert_success'));
    }

    public function getQuotePdf(Request $request)
    {
        $quote_pdf = $this->quoteModel->getQuotePdf($request->id, $request->type);

        if (!$quote_pdf) {
            return api_response(null, __('response.quote.pdf_failed'), 500);
        }
        return $quote_pdf;
    }

    public function shareQuote($id)
    {
        $quote_share = $this->quoteModel->shareQuote($id);

        if (!$quote_share) {
            return api_response(null, __('response.quote.share_failed'), 500);
        }
        return api_response($quote_share, __('response.quote.share_success'));
    }

    public function sendQuoteNotification($id)
    {
        $quote_send = $this->quoteModel->sendQuoteNotification($id);

        if (!$quote_send) {
            return api_response(null, __('response.quote.send_failed'), 500);
        }
        return api_response($quote_send, __('response.quote.send_success'));
    }
}
