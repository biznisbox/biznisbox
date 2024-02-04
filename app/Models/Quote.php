<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\URL;

class Quote extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'quotes';

    protected $fillable = [
        'number',
        'sales_person_id',
        'customer_id',
        'payer_id',
        'total',
        'status',
        'default_currency',
        'currency',
        'currency_rate',
        'date',
        'valid_until',
        'footer',
        'tax',
        'discount',
        'discount_type',
        'notes',
        'customer_address_id',
        'customer_name',
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
    ];

    protected $casts = [
        'date' => 'date',
        'valid_until' => 'date',
        'discount' => 'float',
        'tax' => 'float',
        'total' => 'float',
        'currency_rate' => 'float',
    ];

    protected $dates = ['date', 'valid_until', 'deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['deleted_at', 'updated_at', 'created_at'];

    protected $appends = ['preview', 'download'];

    public function getPreviewAttribute()
    {
        return URL::signedRoute('quote.pdf', [
            'id' => $this->id,
            'type' => 'preview',
            'lang' => app()->getLocale(),
        ]);
    }

    public function getDownloadAttribute()
    {
        return URL::signedRoute('quote.pdf', [
            'id' => $this->id,
            'type' => 'download',
            'lang' => app()->getLocale(),
        ]);
    }

    public function generateTags(): array
    {
        return ['Quote'];
    }

    public function items()
    {
        return $this->hasMany(QuoteItems::class);
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

    public function getQuotes()
    {
        $quotes = $this->with('items')->get();
        return $quotes;
    }

    public function createQuote($data)
    {
        $data = $this->setPayerData($data, $data['payer_id'], $data['payer_address_id']);
        $data = $this->setCustomerData($data, $data['customer_id'], $data['customer_address_id']);
        $data['default_currency'] = settings('default_currency');
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
            return $quote;
        }
    }

    public function updateQuote($id, $data)
    {
        $data = $this->setPayerData($data, $data['payer_id'], $data['payer_address_id']);
        $data = $this->setCustomerData($data, $data['customer_id'], $data['customer_address_id']);
        $quote = $this->find($id);

        $quote = $quote->update($data);
        if ($quote) {
            $quote = $this->find($id);
            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $item['total'] = calculateItemTotalHelper($item);
                    if (isset($item['id'])) {
                        $quote
                            ->items()
                            ->where('id', $item['id'])
                            ->update($item);
                    } else {
                        $quote->items()->create($item);
                    }
                }
            }
            $items = $quote->items()->get();
            $total = calculateTotalHelper($items, $quote['discount'], $quote['discount_type'], $quote['currency_rate']);
            $quote->total = $total;
            $quote->save();
            return $quote;
        }
    }

    public function deleteQuote($id)
    {
        $quote = $this->find($id);
        $quote->items()->delete();
        $quote->delete();
        return $quote;
    }

    public function getQuote($id)
    {
        try {
            DB::beginTransaction();
            $quote = $this->with('items', 'salesPerson:id,first_name,last_name,email')->find($id);
            DB::commit();
            activity_log(user_data()->data->id, 'get quote pdf', $id, 'App\Models\Quote', 'getQuotePdf');
            return $quote;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public static function getQuoteNumber()
    {
        $number = generate_next_number(settings('quote_number_format'), 'quote');
        return $number;
    }

    public function convertQuoteToInvoice($id)
    {
        try {
            DB::beginTransaction();
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
            DB::commit();
            activity_log(user_data()->data->id, 'convert quote to invoice', $id, 'App\Models\Quote', 'convertQuoteToInvoice');
            return $invoice->id;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function getClientQuote($id)
    {
        $quote = $this->with('items', 'salesPerson:id,first_name,last_name,email')->find($id);
        unset($quote->notes); // remove notes from client quote - for security reasons (notes are internal)
        // Change the status to viewed
        if ($quote->status != 'viewed' && $quote->status != 'accepted' && $quote->status != 'rejected' && $quote->status != 'converted') {
            $quote->status = 'viewed';
            $quote->save();
        }
        return $quote;
    }

    public function getQuotePdf($id, $type = 'stream')
    {
        $quote = $this->with('items')->find($id);
        $pdf = PDF::loadView('pdfs.quote', compact('quote'));

        if ($type == 'attach') {
            return $pdf->output();
        }

        if ($type == 'download') {
            activity_log(null, 'DownloadQuote', $quote->id, 'Quote', 'Quote');
            return $pdf->download('Quote ' . $quote->number . '.pdf');
        } else {
            activity_log(null, 'StreamQuote', $quote->id, 'Quote', 'Quote');
            return $pdf->stream('Quote ' . $quote->number . '.pdf');
        }
    }

    public function shareQuote($id)
    {
        $quote = $this->find($id);
        $key = generate_external_key('quote', $quote->id);
        $url = url('/client/quote/' . $id . '?key=' . $key);
        return $url;
    }

    public function clientAcceptRejectQuote($id, $status)
    {
        $quote = $this->find($id);
        $quote->status = $status; // accepted or rejected
        $quote->save();
        return $quote;
    }

    protected function setCustomerData($data, $customerId, $customerAddressId)
    {
        if (!$customerId) {
            $data['customer_id'] = null;
            $data['address_id'] = null;
            $data['customer_name'] = null;
            $data['customer_address'] = null;
            $data['customer_city'] = null;
            $data['customer_zip_code'] = null;
            $data['customer_country'] = null;
            return $data;
        }
        $partner = Partner::find($customerId);
        if ($customerAddressId) {
            $address = PartnerAddress::where('partner_id', $customerId)->where('id', $customerAddressId)->get()[0];
        }
        $data['customer_id'] = $partner->id;
        $data['customer_name'] = $partner->name;
        $data['customer_address_id'] = $address->id ?? null;
        $data['customer_address'] = $address->address ?? null;
        $data['customer_city'] = $address->city ?? null;
        $data['customer_zip_code'] = $address->zip_code ?? null;
        $data['customer_country'] = $address->country ?? null;
        return $data;
    }

    protected function setPayerData($data, $payerId, $payerAddressId)
    {
        if (!$payerId) {
            $data['payer_id'] = null;
            $data['payer_address_id'] = null;
            $data['payer_name'] = null;
            $data['payer_address'] = null;
            $data['payer_city'] = null;
            $data['payer_zip_code'] = null;
            $data['payer_country'] = null;
            return $data;
        }
        $partner = Partner::find($payerId);
        if ($payerAddressId) {
            $address = PartnerAddress::where('partner_id', $payerId)->where('id', $payerAddressId)->get()[0];
        }
        $data['payer_id'] = $partner->id;
        $data['payer_name'] = $partner->name;
        $data['payer_address_id'] = $address->id ?? null;
        $data['payer_address'] = $address->address ?? null;
        $data['payer_city'] = $address->city ?? null;
        $data['payer_zip_code'] = $address->zip_code ?? null;
        $data['payer_country'] = $address->country ?? null;
        return $data;
    }
}
