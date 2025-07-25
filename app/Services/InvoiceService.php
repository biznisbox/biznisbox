<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaction;
use App\Models\PartnerContact;
use Illuminate\Support\Facades\Mail;

class InvoiceService
{
    private $invoiceModel;
    public function __construct()
    {
        $this->invoiceModel = new Invoice();
    }

    public function getInvoices()
    {
        $invoices = $this->invoiceModel->getInvoices();
        return $invoices;
    }

    public function getInvoice($id)
    {
        $invoice = $this->invoiceModel->getInvoice($id);
        return $invoice;
    }

    public function createInvoice($data)
    {
        $invoice = $this->invoiceModel->createInvoice($data);
        return $invoice;
    }

    public function updateInvoice($id, $data)
    {
        $invoice = $this->invoiceModel->updateInvoice($id, $data);
        return $invoice;
    }

    public function deleteInvoice($id)
    {
        $invoice = $this->invoiceModel->deleteInvoice($id);
        return $invoice;
    }

    public function getInvoiceNumber()
    {
        $invoice = $this->invoiceModel->getInvoiceNumber();
        return $invoice;
    }

    public function shareInvoice($id)
    {
        $invoice = $this->invoiceModel->shareInvoice($id);
        return $invoice;
    }

    public function getInvoicePdf($id, $type = 'stream')
    {
        $invoice = $this->getInvoice($id);
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
        $pdf = PDF::loadView('pdfs.invoice', compact('invoice', 'settings'));

        if ($type == 'attach') {
            return $pdf->output();
        }
        if ($type == 'download') {
            createActivityLog('DownloadInvoice', $invoice->id, 'App\Models\Invoice', 'Invoice');
            return $pdf->download('Invoice ' . $invoice->number . '.pdf');
        } else {
            createActivityLog('ViewInvoice', $invoice->id, 'App\Models\Invoice', 'Invoice');
            return $pdf->stream('Invoice ' . $invoice->number . '.pdf');
        }
    }

    public function addInvoicePayment($invoice_id, $data)
    {
        $invoice = $this->invoiceModel->find($invoice_id);

        $transaction = Transaction::create([
            'number' => Transaction::getTransactionNumber(),
            'type' => 'income',
            'amount' => $data['amount'],
            'date' => $data['date'] ?? date('Y-m-d'),
            'invoice_id' => $invoice_id,
            'customer_id' => $invoice->customer_id,
            'supplier_id' => $invoice->payer_id,
            'currency' => $invoice->currency,
            'currency_rate' => $invoice->currency_rate,
        ]);

        if ($transaction) {
            $transactions = Transaction::where('invoice_id', $invoice_id)->get();
            // Calculate total of all transactions
            $total = 0;
            foreach ($transactions as $transaction) {
                if ($transaction->type == 'income') {
                    $total += $transaction->amount;
                }
                if ($transaction->type == 'expense') {
                    $total -= $transaction->amount;
                }
                // transaction type can be 'income' or 'expense'
            }
            // Update invoice total
            if ($total == $invoice->total) {
                $invoice->status = 'paid';
            }
            if ($total > 0 && $total < $invoice->total) {
                $invoice->status = 'partial'; // 'partial' or 'paid'
            }
            if ($total > $invoice->total) {
                $invoice->status = 'overpaid';
            }
            $invoice->save();
            incrementLastItemNumber('transaction', settings('transaction_number_format'));
            createActivityLog('addInvoicePayment', $invoice_id, 'App\Models\Invoice', 'Invoice');
            sendWebhookForEvent('invoice:payment_received', $transaction->toArray());
            return $transaction;
        }
    }

    public function getInvoicePayments($invoice_id)
    {
        $transactions = Transaction::where('invoice_id', $invoice_id)->get();
        return $transactions;
    }

    public function sendInvoiceNotification($invoice_id, $contact = null)
    {
        $invoice = $this->invoiceModel->getClientInvoice($invoice_id);

        if ($contact != null) {
            $url = url(
                '/client/invoice/' .
                    $invoice->id .
                    '?key=' .
                    generateExternalKey('invoice', $invoice->id, 'system', null, $contact->email, 'email') .
                    '&lang=' .
                    app()->getLocale(),
            );

            Mail::to($contact->email)->send(new \App\Mail\Client\InvoiceNotification($invoice, $url, $contact));
            return true;
        } else {
            $contacts = PartnerContact::where('partner_id', $invoice->customer_id)
                ->orWhere('partner_id', $invoice->payer_id)
                ->where('is_primary', true)
                ->whereNotNull('email')
                ->get();

            foreach ($contacts as $contact) {
                $url = $url = url(
                    '/client/invoice/' .
                        $invoice->id .
                        '?key=' .
                        generateExternalKey('invoice', $invoice->id, 'system', null, $contact->email, 'email') .
                        '&lang=' .
                        app()->getLocale(),
                );

                Mail::to($contact->email)->send(new \App\Mail\Client\InvoiceNotification($invoice, $url, $contact));
            }
        }

        if ($invoice->status != 'paid' && $invoice->status != 'overpaid' && $invoice->status != 'partial' && $invoice->status != 'sent') {
            $invoice->status = 'sent';
            $invoice->save();
        }
        createActivityLog('sendInvoiceNotification', $invoice_id, 'App\Models\Invoice', 'Invoice');
        return true;
    }
}
