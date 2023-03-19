<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\InvoiceItems;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\URL;
use App\Mail\Customer\InvoiceNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Invoice extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'created_by',
        'customer_id',
        'payer_id',
        'number',
        'status',
        'currency',
        'currency_rate',
        'payment_method',
        'customer_name',
        'customer_address',
        'customer_city',
        'customer_zip_code',
        'customer_country',
        'payer_name',
        'payer_address',
        'payer_city',
        'payer_zip_code',
        'payer_country',
        'date',
        'due_date',
        'notes',
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
    ];

    public function generateTags(): array
    {
        return ['Invoice'];
    }

    public function items()
    {
        return $this->hasMany(InvoiceItems::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getInvoiceNumberAttribute()
    {
        return $this->prefix . $this->number;
    }

    public function getInvoiceTotalAttribute()
    {
        return $this->items->sum('total');
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
            $invoice = Invoice::with('items')->find($id);
            $invoice->preview = URL::signedRoute('invoice.pdf', ['id' => $invoice->id, 'type' => 'preview', 'lang' => app()->getLocale()]);
            $invoice->download = URL::signedRoute('invoice.pdf', [
                'id' => $invoice->id,
                'type' => 'download',
                'lang' => app()->getLocale(),
            ]);
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
     *
     * @param [array] $data
     * @return boolean success or fail to create invoice
     */
    public function createInvoice($data)
    {
        DB::beginTransaction();

        if (isset($data['customer_id'])) {
            $customer = Customer::with('addresses')->find($data['customer_id']);
            $customer_address = $customer->addresses->where('type', 'billing')->first();
            $data['customer_name'] = $customer->name;
            $data['customer_address'] = $customer_address->address;
            $data['customer_city'] = $customer_address->city;
            $data['customer_zip_code'] = $customer_address->zip_code;
            $data['customer_country'] = $customer_address->country;
        }

        if (isset($data['payer_id'])) {
            $payer = Customer::with('addresses')->find($data['payer_id']);
            $payer_address = $payer->addresses->where('type', 'billing')->first();
            $data['payer_name'] = $payer->name;
            $data['payer_address'] = $payer_address->address;
            $data['payer_city'] = $payer_address->city;
            $data['payer_zip_code'] = $payer_address->zip_code;
            $data['payer_country'] = $payer_address->country;
        }

        $invoice = Invoice::create($data);

        if ($invoice) {
            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $item['invoice_id'] = $invoice->id;
                    $item['product_id'] = $item['product_id'];
                    $this->decrementStock($item['product_id'], $item['quantity']);
                    $item['total'] = $this->calculateItemTotal($item);
                    InvoiceItems::create($item);
                }
            }
            $total = $this->calculateInvoiceTotal($invoice);

            $invoice->total = $total;
            $invoice->save();
            incrementLastItemNumber('invoice');
            DB::commit();
            return true;
        }
    }

    /**
     * Update invoice
     *
     * @param [array] $data
     * @return boolean success or fail to update invoice
     */
    public function updateInvoice($id, $data)
    {
        try {
            DB::beginTransaction();

            if (isset($data['customer_id'])) {
                $customer = Customer::with('addresses')->find($data['customer_id']);
                $customer_address = $customer->addresses->where('type', 'billing')->first();
                $data['customer_name'] = $customer->name;
                $data['customer_address'] = $customer_address->address;
                $data['customer_city'] = $customer_address->city;
                $data['customer_zip_code'] = $customer_address->zip_code;
                $data['customer_country'] = $customer_address->country;
            }

            if (isset($data['payer_id'])) {
                $payer = Customer::with('addresses')->find($data['payer_id']);
                $payer_address = $payer->addresses->where('type', 'billing')->first();
                $data['payer_name'] = $payer->name;
                $data['payer_address'] = $payer_address->address;
                $data['payer_city'] = $payer_address->city;
                $data['payer_zip_code'] = $payer_address->zip_code;
                $data['payer_country'] = $payer_address->country;
            }

            $invoice = $this->find($id);
            if ($invoice->status == 'paid') {
                return false;
            }
            $invoice = $invoice->update($data);

            if ($invoice) {
                $invoice = $this->find($id);
                if (isset($data['items'])) {
                    $this->items()
                        ->where('invoice_id', $id)
                        ->get()
                        ->each(function ($item) {
                            $this->incrementStock($item->product_id, $item->quantity);
                            $item->delete();
                        });
                    foreach ($data['items'] as $item) {
                        $item['invoice_id'] = $invoice->id;
                        $item['product_id'] = $item['product_id'];
                        $this->decrementStock($item['product_id'], $item['quantity']);
                        $item['total'] = $this->calculateItemTotal($item);
                        $this->items()->create($item);
                    }
                }

                $total = $this->calculateInvoiceTotal($invoice);
                $invoice->total = $total;
                $invoice->save();
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Delete invoice
     *
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
                    ->get()
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

    public function calculateItemTotal($item)
    {
        $total = 0;
        $total += $item['quantity'] * $item['price'];
        if ($item['discount']) {
            $total -= ($total * $item['discount']) / 100;
        }
        if ($item['tax']) {
            $total += ($total * $item['tax']) / 100;
        }
        return $total;
    }

    public function calculateItemsTotal($items)
    {
        $total = 0;
        foreach ($items as $item) {
            $item['total'] = $this->calculateItemTotal($item);
            $total += $item['total'];
        }
        return $total;
    }

    public function calculateInvoiceTotal($invoice)
    {
        $items = InvoiceItems::where('invoice_id', $invoice->id)->get();
        $total = $this->calculateItemsTotal($items);

        if ($invoice->discount) {
            $total = $total - ($total * $invoice->discount) / 100;
        }

        return $total;
    }

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

    public static function getInvoiceNumber()
    {
        $number = generate_next_number(settings('invoice_number_format'), 'invoice');
        return $number;
    }

    public function shareInvoice($id)
    {
        $invoice = $this->find($id);
        $key = generate_external_key('invoice', $invoice->id);
        $url = url('/client/invoice/' . $id . '?key=' . $key . '&lang=' . app()->getLocale());
        return $url;
    }

    public function getClientInvoice($id)
    {
        try {
            DB::beginTransaction();
            $invoice = Invoice::with('items')->find($id);
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

    public function sendInvoice($id)
    {
        $invoice = $this->with('customer', 'payer', 'items')->find($id);
        $link = $this->shareInvoice($id);
        if ($invoice->status == 'draft') {
            // SEND MAILS TO CUSTOMER AND PAYER
            $receivers = [];
            if ($invoice->customer != null && $invoice->customer->email) {
                $receivers[] = $invoice->customer->email;
            }

            if ($invoice->payer != null && $invoice->payer->email && $invoice->payer->email != $invoice->customer->email) {
                $receivers[] = $invoice->payer->email;
            }

            if ($receivers) {
                $pdf = $this->getInvoicePdf($invoice->id, 'attach');

                foreach ($receivers as $receiver) {
                    Mail::to($receiver)->send(new InvoiceNotification($invoice, $link, $pdf));
                }
                $invoice->status = 'sent';
                $invoice->save();
                activity_log(user_data()->data->id, 'SendInvoice', $invoice->id, 'App\Models\Invoice', 'Invoice');
                return true;
            }
        }
        return false;
    }
}
