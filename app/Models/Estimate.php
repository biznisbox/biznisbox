<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\URL;
use App\Mail\Customer\EstimateNotification;
use Illuminate\Support\Facades\Mail;

class Estimate extends Model implements Auditable
{
    use HasFactory, HasUuids, \OwenIt\Auditing\Auditable;

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
        'valid_until',
        'notes',
        'discount',
        'tax',
        'total',
    ];

    protected $casts = [
        'date' => 'date',
        'valid_until' => 'date',
        'discount' => 'float',
        'tax' => 'float',
        'total' => 'float',
    ];

    public function generateTags(): array
    {
        return ['Estimate'];
    }

    public function items()
    {
        return $this->hasMany(EstimateItems::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function customer_address()
    {
        return $this->belongsTo(CustomerAddress::class);
    }

    /**
     * Get all estimates with relations
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEstimates()
    {
        return $this->with('items', 'customer', 'payer', 'createdBy')->get();
    }

    /**
     * Create new estimate
     *
     * @param object $data Estimate data for insert into database
     * @return bool|string Returns true if success or error message if failed
     */

    public function createEstimate($data)
    {
        DB::beginTransaction();

        try {
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

            $data['created_by'] = user_data()->data->id;

            $estimate = $this->create($data);
            foreach ($data['items'] as $item) {
                $item['estimate_id'] = $estimate->id;
                $item['product_id'] = $item['product_id'] ?? null;
                $item['total'] = $this->calculateItemTotal($item);
                EstimateItems::create($item);
            }

            $total = $this->calculateEstimateTotal($estimate);
            $estimate->total = $total;
            $estimate->save();
            incrementLastItemNumber('estimate');
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    /**
     * Update estimate
     *
     * @param object $data Estimate data for update into database
     * @return bool|string Returns true if success or error message if failed
     */

    public function updateEstimate($id, $data)
    {
        DB::beginTransaction();
        try {
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

            $estimate = $this->find($id);
            if ($estimate->status == 'accepted') {
                return false;
            }

            $estimate->update($data);

            if (isset($data['items'])) {
                $items = EstimateItems::where('estimate_id', $estimate->id)
                    ->get()
                    ->each->delete();
                foreach ($data['items'] as $item) {
                    $item['estimate_id'] = $estimate->id;
                    $item['total'] = $this->calculateItemTotal($item);
                    EstimateItems::create($item);
                }
            }

            $estimate->total = $this->calculateEstimateTotal($estimate);
            $estimate->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    /**
     * Delete estimate
     *
     * @param int $id Estimate id for delete from database
     * @return bool|string Returns true if success or error message if failed
     */
    public function deleteEstimate($id)
    {
        DB::beginTransaction();

        try {
            $estimate = $this->find($id);
            $estimate->delete();

            $this->items()
                ->where('estimate_id', $estimate->id)
                ->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function getEstimate($id)
    {
        try {
            DB::beginTransaction();
            $estimate = $this->with('items', 'customer', 'payer')->find($id);
            $estimate->preview = URL::signedRoute('estimate.pdf', [
                'id' => $estimate->id,
                'type' => 'preview',
                'lang' => app()->getLocale(),
            ]);
            $estimate->download = URL::signedRoute('estimate.pdf', [
                'id' => $estimate->id,
                'type' => 'download',
                'lang' => app()->getLocale(),
            ]);
            DB::commit();
            activity_log(user_data()->data->id, 'get estimate', $id, 'App\Models\Estimate', 'getEstimate');
            return $estimate;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public static function getEstimateNumber()
    {
        $number = generate_next_number(settings('estimate_number_format'), 'estimate');
        return $number;
    }

    public function convertEstimateToInvoice($id)
    {
        try {
            DB::beginTransaction();
            $estimate = $this->with('items')->find($id);

            $invoice = new Invoice();
            $invoice = $invoice->create([
                'number' => $invoice->getInvoiceNumber(),
                'customer_id' => $estimate->customer_id,
                'payer_id' => $estimate->payer_id,
                'total' => $estimate->total,
                'status' => 'unpaid',
                'currency' => $estimate->currency,
                'payment_method' => $estimate->payment_method,
                'date' => $estimate->date,
                'due_date' => $estimate->valid_until,
                'footer' => $estimate->footer,
                'tax' => $estimate->tax,
                'discount' => $estimate->discount,
                'notes' => $estimate->notes,
                'customer_name' => $estimate->customer_name,
                'customer_address' => $estimate->customer_address,
                'customer_city' => $estimate->customer_city,
                'customer_zip_code' => $estimate->customer_zip_code,
                'customer_country' => $estimate->customer_country,
                'payer_name' => $estimate->payer_name,
                'payer_address' => $estimate->payer_address,
                'payer_city' => $estimate->payer_city,
                'payer_zip_code' => $estimate->payer_zip_code,
                'payer_country' => $estimate->payer_country,
            ]);

            $invoice_id = $invoice->id;

            foreach ($estimate['items'] as $item) {
                $invoice->items()->create([
                    'invoice_id' => $invoice_id,
                    'product_id' => $item->product_id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'discount' => $item->discount,
                    'tax' => $item->tax,
                    'unit' => $item->unit,
                    'total' => $item->total,
                ]);
            }

            $estimate->status = 'converted';
            $estimate->save();

            DB::commit();
            activity_log(user_data()->data->id, 'estimate to invoice', $id, 'App\Models\Estimate', 'estimateToInvoice');
            return $invoice->id;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function getClientEstimate($id)
    {
        $estimate = $this->with('items', 'customer', 'payer')->find($id);
        $estimate->preview = URL::signedRoute('estimate.pdf', ['id' => $estimate->id, 'type' => 'preview', 'lang' => app()->getLocale()]);
        $estimate->download = URL::signedRoute('estimate.pdf', ['id' => $estimate->id, 'type' => 'download', 'lang' => app()->getLocale()]);
        return $estimate;
    }

    public function getEstimatePdf($id, $type = 'stream')
    {
        $estimate = $this->getClientEstimate($id);
        $pdf = PDF::loadView('pdfs.estimate', compact('estimate'));

        if ($type == 'attach') {
            return $pdf->output();
        }

        if ($type == 'download') {
            activity_log(null, 'DownloadEstimate', $estimate->id, 'Estimate', 'Estimate');
            return $pdf->download('Estimate ' . $estimate->number . '.pdf');
        } else {
            activity_log(null, 'StreamEstimate', $estimate->id, 'Estimate', 'Estimate');
            return $pdf->stream('Estimate ' . $estimate->number . '.pdf');
        }
    }

    public function sendEstimate($id)
    {
        $estimate = $this->with('customer', 'payer')->find($id);
        $link = $this->shareEstimate($id);

        // SEND MAILS TO CUSTOMER AND PAYER
        $receivers = [];
        if ($estimate->customer != null && $estimate->customer->email) {
            $receivers[] = $estimate->customer->email;
        }

        if ($estimate->payer != null && $estimate->payer->email && $estimate->payer->email != $estimate->customer->email) {
            $receivers[] = $estimate->payer->email;
        }

        if ($receivers) {
            $pdf = $this->getEstimatePdf($id, 'attach');

            foreach ($receivers as $receiver) {
                Mail::to($receiver)->send(new EstimateNotification($estimate, $link, $pdf));
            }
            $estimate->status = 'sent';
            $estimate->save();
            activity_log(user_data()->data->id, 'SendEstimate', $estimate->id, 'App\Models\Estimate', 'sendEstimate');
            return true;
        }
    }

    public function shareEstimate($id)
    {
        $estimate = $this->find($id);
        $key = generate_external_key('estimate', $estimate->id);
        $url = url('/client/estimate/' . $id . '?key=' . $key);
        return $url;
    }

    public function clientAcceptRejectEstimate($id, $status)
    {
        $estimate = $this->find($id);
        $estimate->status = $status; // accepted or rejected
        $estimate->save();
        return $estimate;
    }

    // Additional methods for calculations
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

    public function calculateEstimateTotal($estimate)
    {
        $items = EstimateItems::where('estimate_id', $estimate->id)->get();
        $total = $this->calculateItemsTotal($items);

        if ($estimate->discount) {
            $total = $total - ($total * $estimate->discount) / 100;
        }

        return $total;
    }
}
