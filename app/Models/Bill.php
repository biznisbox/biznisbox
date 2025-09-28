<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\URL;

class Bill extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Bill';

    protected $table = 'bills';

    protected $fillable = [
        'number',
        'supplier_id',
        'supplier_name',
        'supplier_address_id',
        'supplier_address',
        'supplier_city',
        'supplier_zip_code',
        'supplier_country',
        'currency',
        'currency_rate',
        'payment_method_id',
        'status',
        'date',
        'due_date',
        'notes',
        'footer',
        'discount',
        'discount_type', // percent or fixed
        'total',
        'tax',
    ];

    protected $casts = [
        'date' => 'datetime',
        'due_date' => 'datetime',
        'total' => 'double',
        'tax' => 'double',
        'discount' => 'double',
        'currency_rate' => 'double',
    ];

    protected $dates = ['date', 'due_date', 'deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['deleted_at', 'updated_at', 'created_at'];

    protected $appends = ['preview', 'download'];

    public function generateTags(): array
    {
        return ['Bill'];
    }

    public function items()
    {
        return $this->hasMany(BillItem::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'supplier_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(Category::class, 'payment_method_id');
    }

    public function getPreviewAttribute()
    {
        return URL::signedRoute('getBillPdf', [
            'id' => $this->id,
            'type' => 'preview',
        ]);
    }

    public function getDownloadAttribute()
    {
        return URL::signedRoute('getBillPdf', [
            'id' => $this->id,
            'type' => 'download',
        ]);
    }

    public function getBills()
    {
        $bill = $this->with(['items'])->get();
        createActivityLog('retrieve', null, Bill::$modelName, 'Bill');
        return $bill;
    }

    public function getBill($id)
    {
        $bill = $this->with(['items', 'paymentMethod'])->find($id);
        createActivityLog('retrieve', $id, Bill::$modelName, 'Bill');
        return $bill;
    }

    public function createBill($data)
    {
        $data = setPartnerData($data, $data['supplier_id'], $data['supplier_address_id'], 'supplier');
        $bill = $this->create($data);
        if ($bill) {
            if (isset($data['items'])) {
                foreach ($data['items'] as $item) {
                    $item['total'] = calculateItemTotalHelper($item);
                    $bill->items()->create($item);
                }
            }

            $items = $bill->items()->get();
            $total = calculateTotalHelper($items, $data['discount'], $data['discount_type']);

            if ($total == 0) {
                $bill->status = 'paid';
            }

            $bill->total = $total;
            $bill->save();
            sendWebhookForEvent('bill:created', $bill->toArray());
            incrementLastItemNumber('bill', settings('bill_number_format'));
            return $bill;
        }
        return false;
    }

    public function updateBill($id, $data)
    {
        $bill = $this->find($id);
        if ($bill) {
            $data = setPartnerData($data, $data['supplier_id'], $data['supplier_address_id'], 'supplier');
            $data['number'] = $bill['number'];
            $bill->update($data);
            if (isset($data['items'])) {
                $bill->items()->delete(); // delete old items (for update) - to avoid duplicate items
                foreach ($data['items'] as $item) {
                    $item['total'] = calculateItemTotalHelper($item);
                    $bill->items()->create($item);
                }
            }

            $items = $bill->items()->get();
            $total = calculateTotalHelper($items, $data['discount'], $data['discount_type']);
            $bill->total = $total;
            $bill->save();
            sendWebhookForEvent('bill:updated', $bill->toArray());
            return true;
        }
        return false;
    }

    public function deleteBill($id)
    {
        $bill = $this->find($id);
        if (!$bill) {
            return false;
        }
        if ($bill->status == 'paid') {
            return [
                'status' => false,
                'message' => __('responses.bill_not_found_or_already_paid'),
            ];
        }
        $bill->items()->delete();
        $bill->delete();
        sendWebhookForEvent('bill:deleted', ['id' => $id]);
        return $bill;
    }

    public static function getBillNumber()
    {
        return generateNextNumber(settings('bill_number_format'), 'bill');
    }

    /**
     * Update bill status cron job
     */
    public static function updateBillStatusCron()
    {
        $bills = self::where('status', '!=', 'paid')->get();
        foreach ($bills as $bill) {
            if ($bill->due_date < now()) {
                $bill->status = 'overdue';
                $bill->save();
            }
        }
    }
}
