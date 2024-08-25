<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\URL;

class Invoice extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'invoices';

    protected $fillable = [
        'customer_id',
        'payer_id',
        'sales_person_id',
        'type',
        'number',
        'status',
        'currency',
        'currency_rate',
        'default_currency',
        'payment_method',
        'customer_name',
        'customer_address_id',
        'customer_address',
        'customer_city',
        'customer_zip_code',
        'customer_country',
        'payer_address_id',
        'payer_name',
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

    protected $dates = ['date', 'due_date', 'deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['deleted_at', 'updated_at', 'created_at'];

    protected $appends = ['preview', 'download', 'sum_of_payments', 'overpaid_amount'];

    protected function casts(): array
    {
        return [
            'discount' => 'double',
            'tax' => 'double',
            'total' => 'double',
            'currency_rate' => 'double',
            'date' => 'datetime',
            'due_date' => 'datetime',
        ];
    }

    public function generateTags(): array
    {
        return ['Invoice'];
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function customer()
    {
        return $this->belongsTo(Partner::class, 'customer_id');
    }

    public function payer()
    {
        return $this->belongsTo(Partner::class, 'payer_id');
    }

    public function salesPerson()
    {
        return $this->belongsTo(Employee::class, 'sales_person_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'invoice_id');
    }

    public function getPreviewAttribute()
    {
        return URL::signedRoute('getInvoicePdf', [
            'id' => $this->id,
            'type' => 'preview',
        ]);
    }

    public function getDownloadAttribute()
    {
        return URL::signedRoute('getInvoicePdf', [
            'id' => $this->id,
            'type' => 'download',
        ]);
    }

    public function getSumOfPaymentsAttribute()
    {
        return $this->transactions()->sum('amount');
    }

    public function getOverpaidAmountAttribute()
    {
        return $this->sum_of_payments - $this->total;
    }

    /**
     * Get all invoices
     * @return void
     */
    public function getInvoices()
    {
        $invoices = self::with('items')->get();
        if (!$invoices) {
            return null;
        }
        createActivityLog('retrieve', null, 'App\Models\Invoice', 'Invoice');
        return $invoices;
    }

    /**
     * Get invoice by id
     * @param string $id
     * @return object invoice
     */
    public function getInvoice($id)
    {
        $invoice = self::with('items', 'customer', 'payer', 'salesPerson:first_name,id,last_name,email', 'transactions')->find($id);
        if (!$invoice) {
            return null;
        }
        createActivityLog('retrieve', $id, 'App\Models\Invoice', 'Invoice');
        return $invoice;
    }

    /**
     * Create invoice
     * @param [array] $data
     * @return boolean success or fail to create invoice
     */
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
                // if total is 0, invoice is paid
                $invoice->status = 'paid';
            }
            $invoice->save();
            sendWebhookForEvent('invoice:created', $invoice->toArray());
            incrementLastItemNumber('invoice');
            return $invoice;
        }
    }

    /**
     * Update invoice
     * @param array $data
     * @return boolean success or fail to update invoice
     */
    public function updateInvoice($id, $data)
    {
        $data = setPayerData($data, $data['payer_id'], $data['payer_address_id']);
        $data = setCustomerData($data, $data['customer_id'], $data['customer_address_id']);
        $invoice = $this->find($id);
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
            $invoice = $this->find($id);
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
            return $invoice;
        }
    }

    /**
     * Delete invoice
     * @param UUID $id
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
                sendWebhookForEvent('invoice:deleted', $invoice->toArray());
                return true;
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return false;
        }
    }

    /**
     * Decrement stock of product when invoice is created or updated
     * @param uuid $product_id product id
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
        $number = generateNextNumber(settings('invoice_number_format'), 'invoice');
        return $number;
    }

    /**
     * Share invoice by unique key
     * @param UUID $invoice_id
     * @return string url
     */
    public function shareInvoice($invoice_id)
    {
        if ($this->find($invoice_id)) {
            $key = generateExternalKey('invoice', $invoice_id);
            $url = url('/client/invoice/' . $invoice_id . '?key=' . $key . '&lang=' . app()->getLocale());
            createActivityLog('share', $invoice_id, 'App\Models\Invoice', 'Invoice');
            sendWebhookForEvent('invoice:shared', ['invoice_id' => $invoice_id, 'url' => $url]);
            return $url;
        }
        return null;
    }

    /**
     * Get client invoice
     * @param UUID $id - invoice id
     * @param boolean $log - log activity
     * @return JSON invoice
     */
    public function getClientInvoice($id, $log = false)
    {
        $invoice = $this->with('items', 'transactions', 'salesPerson:id,first_name,last_name,email')->find($id);
        unset($invoice->notes);
        if ($log === true) {
            createActivityLog('retrieve', $id, 'App\Models\Invoice', 'Invoice');
        }
        return $invoice;
    }
}
