<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaction;
use App\Models\PartnerContact;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\Client\InvoiceNotification;

class InvoiceService
{
    private $invoiceModel;
    private $productModel;
    public function __construct()
    {
        $this->invoiceModel = new Invoice();
        $this->productModel = new Product();
    }

    /**
     * Get all invoices
     * @return array|null
     */
    public function getInvoices()
    {
        $invoices = $this->invoiceModel->with('items')->get();
        if (!$invoices) {
            return null;
        }
        createActivityLog('retrieve', null, Invoice::$modelName, 'Invoice');
        return $invoices;
    }

    /**
     * Get invoice by id
     * @param string $id
     * @return object invoice
     */
    public function getInvoice($id)
    {
        $invoice = $this->invoiceModel
            ->with('items', 'customer', 'payer', 'paymentMethod', 'salesPerson:first_name,id,last_name,email', 'transactions')
            ->find($id);
        if (!$invoice) {
            return null;
        }
        createActivityLog('retrieve', $id, Invoice::$modelName, 'Invoice');
        return $invoice;
    }

    public function createInvoice($data)
    {
        $data = setPayerData($data, $data['payer_id'], $data['payer_address_id']);
        $data = setCustomerData($data, $data['customer_id'], $data['customer_address_id']);
        $data['default_currency'] = settings('default_currency');
        $data['number'] = $this->getInvoiceNumber();

        if ($data['currency'] == $data['default_currency']) {
            $data['currency_rate'] = 1;
        } else {
            $data['currency_rate'] = getCurrencyRate($data['currency'], $data['default_currency']);
        }

        if ($data['total'] == 'NaN') {
            $data['total'] = 0;
        }

        $invoice = $this->invoiceModel->create($data);
        if ($invoice) {
            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $this->invoiceModel->decrementStock($item['product_id'], $item['quantity']);
                    $item['total'] = calculateItemTotalHelper($item);
                    $invoice->items()->create($item);
                }
            }
            $items = $invoice->items()->get();

            $total = calculateTotalHelper($items, $data['discount'], $data['discount_type'], $data['currency_rate']);
            $invoice->total = $total;
            if ($total == 0) {
                // if total is 0, invoice is paid
                $invoice->status = 'paid';
            }
            $invoice->save();
            sendWebhookForEvent('invoice:created', $invoice->toArray());
            incrementLastItemNumber('invoice', settings('invoice_number_format'));
            saveFilePdfToArchive(
                $this->getInvoicePdf($invoice->id, 'attach'),
                $invoice->number . '.pdf',
                Invoice::$modelName,
                $invoice->id,
                $invoice->partner_id,
            );
            return $invoice;
        }
    }

    public function updateInvoice($id, $data)
    {
        $data = setPayerData($data, $data['payer_id'], $data['payer_address_id']);
        $data = setCustomerData($data, $data['customer_id'], $data['customer_address_id']);
        $invoice = $this->invoiceModel->find($id);
        if ($invoice->status == 'paid') {
            return false;
        }
        if ($data['currency'] == $data['default_currency']) {
            $data['currency_rate'] = 1;
        } else {
            $data['currency_rate'] = getCurrencyRate($data['currency'], $data['default_currency']);
        }

        if ($data['total'] == 'NaN') {
            $data['total'] = 0;
        }

        $invoice = $invoice->update($data);
        if ($invoice) {
            $invoice = $this->invoiceModel->find($id);
            if (isset($data['items'])) {
                $items = $invoice->items()->each(function ($item) {
                    // Increment stock of all items (before update) to avoid negative stock
                    $this->incrementStock($item->product_id, $item->quantity);
                    $item->delete();
                });

                foreach ($data['items'] as $item) {
                    $this->decrementStock($item['product_id'], $item['quantity']);
                    $item['discount_type'] = $data['discount_type'] ?? 'percent';
                    $item['total'] = calculateItemTotalHelper($item);
                    $invoice->items()->create($item);
                }
            }

            $items = $invoice->items()->get();
            $total = calculateTotalHelper($items, $data['discount'], $data['discount_type'], $data['currency_rate']);
            $invoice->total = $total;
            $invoice->save();
            sendWebhookForEvent('invoice:updated', $invoice->toArray());
            saveFilePdfToArchive(
                $this->getInvoicePdf($invoice->id, 'attach'),
                $invoice->number . '.pdf',
                Invoice::$modelName,
                $invoice->id,
                $invoice->partner_id,
            );
            return $invoice;
        }
    }

    public function deleteInvoice($id)
    {
        try {
            DB::beginTransaction();
            $invoice = $this->invoiceModel->find($id);
            if ($invoice) {
                if ($invoice->status == 'paid') {
                    return false;
                }
                $this->invoiceModel
                    ->items()
                    ->where('invoice_id', $id)
                    ->each(function ($item) {
                        $this->incrementStock($item->product_id, $item->quantity);
                        $item->delete();
                    });
                $invoice->delete();
                DB::commit();
                sendWebhookForEvent('invoice:deleted', $invoice->toArray());
                return true;
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return false;
        }
    }

    public function getInvoiceNumber()
    {
        return $this->invoiceModel->getInvoiceNumber();
    }

    public function shareInvoice($id)
    {
        if ($this->invoiceModel->find($id)) {
            $key = generateExternalKey('invoice', $id);
            $url = url('/client/invoice/' . $id . '?key=' . $key . '&lang=' . app()->getLocale());
            createActivityLog('share', $id, Invoice::$modelName, 'Invoice');
            sendWebhookForEvent('invoice:shared', ['invoice_id' => $id, 'url' => $url]);
            return $url;
        }
        return null;
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
            createActivityLog('DownloadInvoice', $invoice->id, Invoice::$modelName, 'Invoice');
            return $pdf->download('Invoice ' . $invoice->number . '.pdf');
        } else {
            createActivityLog('ViewInvoice', $invoice->id, Invoice::$modelName, 'Invoice');
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
            createActivityLog('addInvoicePayment', $invoice_id, Invoice::$modelName, 'Invoice');
            sendWebhookForEvent('invoice:payment_received', $transaction->toArray());
            return $transaction;
        }
    }

    public function getInvoicePayments($invoice_id)
    {
        return Transaction::where('invoice_id', $invoice_id)->get();
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

            setEmailConfig();
            Mail::to($contact->email, $contact->name)->send(new InvoiceNotification($invoice, $url, $contact));
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

                setEmailConfig();

                Mail::to($contact->email, $contact->name)->send(new InvoiceNotification($invoice, $url, $contact));
            }
        }

        if ($invoice->status != 'paid' && $invoice->status != 'overpaid' && $invoice->status != 'partial' && $invoice->status != 'sent') {
            $invoice->status = 'sent';
            $invoice->save();
        }
        createActivityLog('sendInvoiceNotification', $invoice_id, Invoice::$modelName, 'Invoice');
        return true;
    }

    /**
     * Decrement stock of product when invoice is created or updated
     * @param uuid $product_id product id
     * @param integer $quantity quantity
     * @return void
     */
    public function decrementStock($product_id, $quantity = 0)
    {
        if ($product_id == null) {
            return;
        }
        $product = $this->productModel->find($product_id);
        if ($product->stock >= $quantity && $product->stock > 0 && $product->type == 'product') {
            $product->stock -= $quantity;
            $product->save();
        }
    }

    /**
     * Increment stock of product when invoice is deleted or updated
     * @param [uuid] $product_id product id
     * @param integer $quantity quantity
     * @return void
     */
    public function incrementStock($product_id, $quantity = 0)
    {
        if ($product_id == null) {
            return;
        }
        $product = $this->productModel->find($product_id);
        if ($product->stock >= $quantity && $product->stock > 0 && $product->type == 'product') {
            $product->stock += $quantity;
            $product->save();
        }
    }
}
