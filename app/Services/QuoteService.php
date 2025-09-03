<?php

namespace App\Services;

use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Models\PartnerContact;
use App\Mail\Client\QuoteNotification;

class QuoteService
{
    private $quoteModel;

    public function __construct()
    {
        $this->quoteModel = new Quote();
    }

    public function getQuotes()
    {
        $quotes = $this->quoteModel->getQuotes();
        return $quotes;
    }

    public function getQuote($id)
    {
        $quote = $this->quoteModel->getQuote($id);
        return $quote;
    }

    public function createQuote($data)
    {
        $quote = $this->quoteModel->createQuote($data);
        return $quote;
    }

    public function updateQuote($id, $data)
    {
        $quote = $this->quoteModel->updateQuote($id, $data);
        return $quote;
    }

    public function deleteQuote($id)
    {
        $quote = $this->quoteModel->deleteQuote($id);
        return $quote;
    }

    public function getQuoteNumber()
    {
        $quote = $this->quoteModel->getQuoteNumber();
        return $quote;
    }

    public function shareQuote($id)
    {
        $quote = $this->quoteModel->shareQuote($id);
        return $quote;
    }

    public function convertQuoteToInvoice($id)
    {
        $quote = $this->quoteModel->convertQuoteToInvoice($id);
        return $quote;
    }

    /**
     * Function to get quote pdf
     * @param string $id Quote id
     * @param string $type Type of pdf (stream, download, attach)
     * @return void Return quote pdf in stream, download or attach format
     */

    public function getQuotePdf($id, $type = 'stream')
    {
        $quote = $this->quoteModel->getQuote($id);
        $settings = settings([
            'company_name',
            'company_address',
            'company_city',
            'company_zip',
            'company_country',
            'company_phone',
            'company_email',
            'company_vat',
            'company_logo',
            'show_barcode_on_documents',
            'default_currency',
        ]);
        $pdf = PDF::loadView('pdfs.quote', compact('quote', 'settings'));

        if ($type == 'attach') {
            return $pdf->output();
        }
        if ($type == 'download') {
            createActivityLog('DownloadQuote', $quote->id, Quote::$modelName, 'Quote');
            return $pdf->download('Quote ' . $quote->number . '.pdf');
        } else {
            createActivityLog('ViewQuote', $quote->id, Quote::$modelName, 'Quote');
            return $pdf->stream('Quote ' . $quote->number . '.pdf');
        }
    }

    /**
     * Function to send quote notification
     * @param string $quote_id Quote id
     * @param object|string|null $contact Contact email (optional)
     * @return boolean Return true if notification sent
     */
    public function sendQuoteNotification($quote_id, $contact = null)
    {
        $quote = new Quote();
        $quote = $quote->getClientQuote($quote_id);

        if ($contact != null) {
            $url = url(
                '/client/quote/' .
                    $quote->id .
                    '?key=' .
                    generateExternalKey('quote', $quote->id, 'system', null, $contact->email, 'email') .
                    '&lang=' .
                    app()->getLocale(),
            );

            setEmailConfig();

            Mail::to($contact->email, $contact->name)->queue(new QuoteNotification($quote, $url, $contact));
            return true;
        } else {
            $contacts = PartnerContact::where('partner_id', $quote->customer_id)
                ->orWhere('partner_id', $quote->payer_id)
                ->where('is_primary', true)
                ->whereNotNull('email')
                ->get();

            foreach ($contacts as $contact) {
                $url = url(
                    '/client/quote/' .
                        $quote->id .
                        '?key=' .
                        generateExternalKey('quote', $quote->id, 'system', null, $contact->email, 'email') .
                        '&lang=' .
                        app()->getLocale(),
                );

                setEmailConfig();

                Mail::to($contact->email, $contact->name)->queue(new QuoteNotification($quote, $url, $contact));
            }
        }
        if ($quote->status != 'accepted' && $quote->status != 'converted' && $quote->status != 'sent' && $quote->status != 'rejected') {
            $quote->status = 'sent';
            $quote->save();
        }
        createActivityLog('sendQuoteNotification', $quote->id, Quote::$modelName, 'Quote');
        return true;
    }
}
