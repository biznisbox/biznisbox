<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\URL;

class Invoice extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Invoice';

    protected $table = 'invoices';

    protected $fillable = [
        'customer_id',
        'payer_id',
        'sales_person_id',
        'payment_method_id',
        'type',
        'number',
        'status',
        'currency',
        'currency_rate',
        'default_currency',
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

    public function paymentMethod()
    {
        return $this->belongsTo(Category::class, 'payment_method_id');
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
     * Get invoice number
     * @return string invoice number
     */
    public static function getInvoiceNumber()
    {
        return generateNextNumber(settings('invoice_number_format'), 'invoice');
    }

    /**
     * Get client invoice
     * @param UUID $id - invoice id
     * @param boolean $log - log activity
     * @return JSON invoice
     */
    public function getClientInvoice($id, $log = false)
    {
        $invoice = $this->with('items', 'transactions', 'paymentMethod', 'salesPerson:id,first_name,last_name,email')->find($id);
        unset($invoice->notes);
        if ($log === true) {
            createActivityLog('retrieve', $id, Invoice::$modelName, 'Invoice');
        }
        return $invoice;
    }

    /**
     * Update invoice status cron
     * @return void
     */
    public function updateInvoiceStatusCron()
    {
        $invoices = $this->where('status', '!=', 'paid')->get();
        foreach ($invoices as $invoice) {
            if ($invoice->due_date < now()) {
                $invoice->update(['status' => 'overdue']);
            }
        }
    }
}
