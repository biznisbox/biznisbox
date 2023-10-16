<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\InvoiceItems;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\URL;
use App\Models\Transaction;

class Invoice extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'customer_id',
        'payer_id',
        'number',
        'status',
        'currency',
        'currency_rate',
        'payment_method',
        'customer_name',
        'customer_address_id',
        'customer_address',
        'customer_city',
        'customer_zip_code',
        'customer_country',
        'payer_name',
        'payer_address_id',
        'payer_address',
        'payer_city',
        'payer_zip_code',
        'payer_country',
        'date',
        'due_date',
        'notes',
        'footer',
        'discount_type',
        'discount',
        'tax',
        'total',
    ];

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
        'discount' => 'float',
        'tax' => 'float',
        'total' => 'float',
        'currency_rate' => 'float',
    ];

    protected $dates = ['date', 'due_date', 'deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['deleted_at', 'updated_at', 'created_at'];

    protected $appends = ['preview', 'download'];

    public function generateTags(): array
    {
        return ['Invoice'];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'invoice_id');
    }

    public function getPreviewAttribute()
    {
        return URL::signedRoute('invoice.pdf', [
            'id' => $this->id,
            'type' => 'preview',
            'lang' => app()->getLocale(),
        ]);
    }

    public function getDownloadAttribute()
    {
        return URL::signedRoute('invoice.pdf', [
            'id' => $this->id,
            'type' => 'download',
            'lang' => app()->getLocale(),
        ]);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItems::class, 'invoice_id');
    }

    public function customer()
    {
        return $this->belongsTo(Partner::class, 'customer_id');
    }

    public function payer()
    {
        return $this->belongsTo(Partner::class, 'payer_id');
    }

    public function getInvoices()
    {
        return Invoice::with('items', 'customer', 'payer')->get();
    }

    /**
     * Get invoice by id
     * @param string $id
     * @return object invoice
     */
    public function getInvoice($id)
    {
        try {
            DB::beginTransaction();
            $invoice = Invoice::with('items', 'transactions')->find($id);
            DB::commit();
            activity_log(user_data()->data->id, 'get invoice', $id, 'App\Models\Invoice', 'getInvoice');
            return $invoice;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Create invoice
     * @param [array] $data
     * @return boolean success or fail to create invoice
     */
    public function createInvoice($data)
    {
        try {
            DB::beginTransaction();
            $data = $this->setPayerData($data, $data['payer_id'], $data['payer_address_id']);
            $data = $this->setCustomerData($data, $data['customer_id'], $data['customer_address_id']);
            $invoice = Invoice::create($data);
            if ($invoice) {
                if (isset($data['items'])) {
                    foreach ($data['items'] as $item) {
                        $this->decrementStock($item['product_id'], $item['quantity']);
                        $item['total'] = calculateItemTotalHelper($item);
                        $invoice->items()->create($item);
                    }
                }
                $items = $invoice->items()->get();
                $total = calculateTotalHelper($items, $data['discount'], $data['discount_type'], $data['currency_rate']);
                $invoice->total = $total;
                if ($total == 0) {
                    $invoice->status = 'paid'; // if total is 0, invoice is paid
                }
                $invoice->save();
                incrementLastItemNumber('invoice');
                DB::commit();
                return $invoice;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Update invoice
     * @param [array] $data
     * @return boolean success or fail to update invoice
     */
    public function updateInvoice($id, $data)
    {
        try {
            DB::beginTransaction();
            $data = $this->setPayerData($data, $data['payer_id'], $data['payer_address_id']);
            $data = $this->setCustomerData($data, $data['customer_id'], $data['customer_address_id']);
            $invoice = $this->find($id);

            if ($invoice->status == 'paid') {
                return false;
            }
            $invoice = $invoice->update($data);
            if ($invoice) {
                $invoice = $this->find($id);
                if (isset($data['items'])) {
                    $items = $invoice->items()->each(function ($item) {
                        $this->incrementStock($item->product_id, $item->quantity);
                        $item->delete();
                    });

                    foreach ($data['items'] as $item) {
                        $this->decrementStock($item['product_id'], $item['quantity']);
                        $item['total'] = calculateItemTotalHelper($item);
                        $invoice->items()->create($item);
                    }
                }

                $items = $invoice->items()->get();
                $total = calculateTotalHelper($items, $data['discount'], $data['discount_type'], $data['currency_rate']);
                $invoice->total = $total;
                $invoice->save();
                DB::commit();
                return $invoice;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Delete invoice
     * @param [string] $id
     * @return boolean success or fail to delete invoice
     */
    public function deleteInvoice($id)
    {
        try {
            DB::beginTransaction();
            $invoice = $this->find($id);
            if ($invoice) {
                if ($invoice->status == 'paid') {
                    return false;
                }
                $this->items()
                    ->where('invoice_id', $id)
                    ->each(function ($item) {
                        $this->incrementStock($item->product_id, $item->quantity);
                        $item->delete();
                    });
                $invoice->delete();
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Decrement stock of product when invoice is created or updated
     * @param [uuid] $product_id product id
     * @param integer $quantity quantity
     * @return void
     */
    protected function decrementStock($product_id, $quantity = 0)
    {
        if ($product_id == null) {
            return;
        }
        $product = Product::find($product_id);
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
    protected function incrementStock($product_id, $quantity = 0)
    {
        if ($product_id == null) {
            return;
        }
        $product = Product::find($product_id);
        if ($product->stock >= $quantity && $product->stock > 0 && $product->type == 'product') {
            $product->stock += $quantity;
            $product->save();
        }
    }

    /**
     * Get invoice number
     * @return string invoice number
     */
    public static function getInvoiceNumber()
    {
        $number = generate_next_number(settings('invoice_number_format'), 'invoice');
        return $number;
    }

    /**
     * Share invoice with customer
     * @return string invoice number
     */
    public function shareInvoice($id)
    {
        $invoice = $this->find($id);
        $key = generate_external_key('invoice', $invoice->id);
        $url = url('/client/invoice/' . $id . '?key=' . $key . '&lang=' . app()->getLocale());
        return $url;
    }

    /**
     * Get invoice for client
     * @param string $id
     * @return object invoice
     */
    public function getClientInvoice($id)
    {
        try {
            DB::beginTransaction();
            $invoice = $this->with('items', 'transactions')->find($id);
            $invoice->notes = null;
            $invoice->preview = URL::signedRoute('invoice.pdf', ['id' => $invoice->id, 'type' => 'preview', 'lang' => app()->getLocale()]);
            $invoice->download = URL::signedRoute('invoice.pdf', [
                'id' => $invoice->id,
                'type' => 'download',
                'lang' => app()->getLocale(),
            ]);
            DB::commit();
            return $invoice;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getInvoicePdf($id, $type = 'stream')
    {
        $invoice = $this->getClientInvoice($id);
        $pdf = PDF::loadView('pdfs.invoice', compact('invoice'));

        if ($type == 'attach') {
            return $pdf->output();
        }
        if ($type == 'download') {
            activity_log(null, 'DownloadInvoice', $invoice->id, 'Invoice', 'Invoice');
            return $pdf->download('Invoice ' . $invoice->number . '.pdf');
        } else {
            activity_log(null, 'StreamInvoice', $invoice->id, 'Invoice', 'Invoice');
            return $pdf->stream('Invoice ' . $invoice->number . '.pdf');
        }
    }

    /**
     * Add transaction to invoice (payment)
     *
     * @param UUID $id invoice id to add transaction
     * @param double $amount amount of transaction
     * @return void
     */
    public function addTransaction($id, $amount)
    {
        try {
            DB::beginTransaction();
            $invoice = $this->find($id);

            $transaction = Transaction::create([
                'number' => Transaction::getTransactionNumber(),
                'type' => 'income',
                'amount' => $amount,
                'date' => date('Y-m-d'),
                'invoice_id' => $id,
                'customer_id' => $invoice->customer_id,
                'supplier_id' => $invoice->payer_id,
                'currency' => $invoice->currency,
                'currency_rate' => $invoice->currency_rate,
            ]);

            if ($transaction) {
                // Get all transactions of invoice
                $transactions = Transaction::where('invoice_id', $id)->get();

                // Calculate total of all transactions
                $total = 0;
                foreach ($transactions as $transaction) {
                    $total += $transaction->amount;
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
                incrementLastItemNumber('transaction');
                DB::commit();
                return $transaction;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    protected function setPayerData($data, $payerId, $payerAddressId)
    {
        if (!$payerId || !$payerAddressId) {
            $data['payer_id'] = null;
            $data['payer_address_id'] = null;
            $data['payer_name'] = null;
            $data['payer_address'] = null;
            $data['payer_city'] = null;
            $data['payer_zip_code'] = null;
            $data['payer_country'] = null;
            return $data;
        }
        $partner = Partner::where('id', $payerId)->get()[0];
        $address = PartnerAddress::where('partner_id', $payerId)
            ->where('id', $payerAddressId)
            ->get()[0];
        $data['payer_id'] = $partner->id;
        $data['payer_name'] = $partner->name;
        $data['payer_address_id'] = $address->id;
        $data['payer_address'] = $address->address;
        $data['payer_city'] = $address->city;
        $data['payer_zip_code'] = $address->zip_code;
        $data['payer_country'] = $address->country;
        return $data;
    }

    protected function setCustomerData($data, $customerId, $customerAddressId)
    {
        if (!$customerId || !$customerAddressId) {
            $data['customer_id'] = null;
            $data['address_id'] = null;
            $data['customer_name'] = null;
            $data['customer_address'] = null;
            $data['customer_city'] = null;
            $data['customer_zip_code'] = null;
            $data['customer_country'] = null;
            return $data;
        }
        $partner = Partner::where('id', $customerId)->get()[0];
        $address = PartnerAddress::where('partner_id', $customerId)
            ->where('id', $customerAddressId)
            ->get()[0];
        $data['customer_id'] = $partner->id;
        $data['customer_name'] = $partner->name;
        $data['customer_address_id'] = $address->id;
        $data['customer_address'] = $address->address;
        $data['customer_city'] = $address->city;
        $data['customer_zip_code'] = $address->zip_code;
        $data['customer_country'] = $address->country;
        return $data;
    }
}
