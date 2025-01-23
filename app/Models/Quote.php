<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\URL;

class Quote extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'quotes';
    protected $fillable = [
        'customer_id',
        'payer_id',
        'sales_person_id',
        'type',
        'number',
        'status',
        'currency',
        'default_currency',
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
        'valid_until',
        'notes',
        'footer',
        'discount_type',
        'discount',
        'tax',
        'total',
    ];

    protected $dates = ['date', 'valid_until', 'deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['deleted_at', 'updated_at', 'created_at'];

    protected $appends = ['preview', 'download'];

    protected function casts(): array
    {
        return [
            'discount' => 'double',
            'tax' => 'double',
            'total' => 'double',
            'currency_rate' => 'double',
            'valid_until' => 'datetime',
            'date' => 'datetime',
        ];
    }
    public function generateTags(): array
    {
        return ['Quote'];
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
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

    public function getPreviewAttribute()
    {
        return URL::signedRoute('getQuotePdf', [
            'id' => $this->id,
            'type' => 'preview',
        ]);
    }

    public function getDownloadAttribute()
    {
        return URL::signedRoute('getQuotePdf', [
            'id' => $this->id,
            'type' => 'download',
        ]);
    }

    public function getQuotes()
    {
        $quotes = $this->with('items')->get();
        createActivityLog('retrieve', null, 'App\Models\Quote', 'Quote');
        return $quotes;
    }

    public function createQuote($data)
    {
        $data = setPayerData($data, $data['payer_id'], $data['payer_address_id']);
        $data = setCustomerData($data, $data['customer_id'], $data['customer_address_id']);
        $data['default_currency'] = settings('default_currency');
        $data['number'] = $this->getQuoteNumber();
        $quote = $this->create($data);
        if ($quote) {
            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $item['total'] = calculateItemTotalHelper($item);
                    $quote->items()->create($item);
                }
            }
            $items = $quote->items()->get();
            $total = calculateTotalHelper($items, $quote['discount'], $quote['discount_type'], $quote['currency_rate']);
            $quote->total = $total;
            $quote->save();
            incrementLastItemNumber('quote');
            sendWebhookForEvent('quote:created', $quote->toArray());
            return $quote;
        }
    }

    public function updateQuote($id, $data)
    {
        $data = setPayerData($data, $data['payer_id'], $data['payer_address_id']);
        $data = setCustomerData($data, $data['customer_id'], $data['customer_address_id']);
        $quote = $this->find($id);

        $quote = $quote->update($data);
        if ($quote) {
            $quote = $this->find($id);
            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $item['total'] = calculateItemTotalHelper($item);
                    if (isset($item['id'])) {
                        $quote->items()->where('id', $item['id'])->update($item);
                    } else {
                        $quote->items()->create($item);
                    }
                }
            }
            $items = $quote->items()->get();
            $total = calculateTotalHelper($items, $quote['discount'], $quote['discount_type'], $quote['currency_rate']);
            $quote->total = $total;
            $quote->save();
            sendWebhookForEvent('quote:updated', $quote->toArray());
            return $quote;
        }
    }

    public function deleteQuote($id)
    {
        $quote = $this->find($id);
        $quote->items()->delete();
        $quote->delete();
        sendWebhookForEvent('quote:deleted', $quote->toArray());
        return $quote;
    }

    public function getQuote($id)
    {
        $quote = $this->with('items')->find($id);
        createActivityLog('retrieve', $id, 'App\Models\Quote', 'Quote');
        return $quote;
    }

    public static function getQuoteNumber()
    {
        $number = generateNextNumber(settings('quote_number_format'), 'quote');
        return $number;
    }

    public function convertQuoteToInvoice($id)
    {
        $quote = $this->with('items')->find($id);

        $quote->status = 'converted';
        $quote->save();

        $invoice = new Invoice();
        $quote->number = Invoice::getInvoiceNumber();
        $quote->status = 'unpaid';

        $invoice = $invoice->create($quote->toArray());

        foreach ($quote['items'] as $item) {
            $invoice->items()->create($item->toArray());
        }
        incrementLastItemNumber('invoice');
        createActivityLog('convert_to_invoice', $id, 'App\Models\Quote', 'Quote');
        sendWebhookForEvent('quote:converted', $invoice->toArray());
        return $invoice->id;
    }

    public function getClientQuote($id, $log = false, $update_viewed = false)
    {
        $quote = $this->with('items', 'salesPerson:id,first_name,last_name,email')->find($id);
        unset($quote->notes);

        if ($log) {
            createActivityLog('retrieve', $id, 'App\Models\Quote', 'Quote');
        }

        if ($update_viewed) {
            if (
                $quote->status != 'viewed' &&
                $quote->status != 'accepted' &&
                $quote->status != 'rejected' &&
                $quote->status != 'converted'
            ) {
                $quote->status = 'viewed';
                $quote->save();
            }
        }
        return $quote;
    }

    /**
     * Share invoice by unique key
     * @param UUID $invoice_id
     * @return string url
     */
    public function shareQuote($quote_id)
    {
        if ($this->find($quote_id)) {
            $key = generateExternalKey('quote', $quote_id);
            $url = url('/client/quote/' . $quote_id . '?key=' . $key . '&lang=' . app()->getLocale());
            createActivityLog('ShareQuote', $quote_id, 'App\Models\Quote', 'Quote');
            sendWebhookForEvent('quote:shared', ['quote_id' => $quote_id, 'url' => $url]);
            return $url;
        }
        return null;
    }

    /**
     * Quote accept or reject by client
     * @param UUID $id
     * @param UUID $status
     * @param string $key
     * @return boolean
     */
    public function clientAcceptRejectQuote($id, $status, $key = null)
    {
        $quote = $this->find($id);
        $quote->status = $status; // accepted or rejected
        $quote->save();
        createActivityLog('AcceptRejectQuoteByClient', $id, 'App\Models\Quote', 'Quote', null, null, 'external', $key);
        sendWebhookForEvent('quote:accepted_rejected', ['quote_id' => $id, 'status' => $status, 'key' => $key]);
        return $quote;
    }

    /**
     * Update status of quote cron
     */
    public function updateQuoteStatusCron()
    {
        $quotes = $this->whereNotIn('status', ['accepted', 'rejected', 'converted'])->get();
        foreach ($quotes as $quote) {
            if ($quote->valid_until < now()) {
                $quote->status = 'expired';
                $quote->save();
            }
        }
    }
}
