<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Bill extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

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
        'payment_method',
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
        'total' => 'float',
        'tax' => 'float',
        'discount' => 'float',
        'currency_rate' => 'float:4',
    ];

    protected $dates = ['date', 'due_date', 'deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['deleted_at', 'updated_at', 'created_at'];

    public function generateTags(): array
    {
        return ['Bill'];
    }

    public function items()
    {
        return $this->hasMany(BillItems::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'supplier_id');
    }

    public function getBills()
    {
        return $this->with(['items', 'partner', 'partner.addresses'])->get();
    }

    public function getBill($id)
    {
        return $this->with(['items', 'partner'])->find($id);
    }

    public function createBill($data)
    {
        try {
            DB::beginTransaction();
            $data = $this->setSupplierData($data, $data['supplier_id'], $data['supplier_address_id']);
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
                $bill->total = $total;
                $bill->save();
                incrementLastItemNumber('bill');
                DB::commit();
                return $bill;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function updateBill($id, $data)
    {
        try {
            $bill = $this->find($id);
            if ($bill) {
                $data = $this->setSupplierData($data, $data['supplier_id'], $data['supplier_address_id']);
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
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteBill($id)
    {
        $bill = $this->find($id);
        $bill->items()->delete();
        $bill->delete();
        return $bill;
    }

    public static function getBillNumber()
    {
        $number = generate_next_number(settings('bill_number_format'), 'bill');
        return $number;
    }

    protected function setSupplierData($data, $supplier_id = null, $address_id = null)
    {
        if (!$supplier_id || !$address_id) {
            $data['supplier_id'] = null;
            $data['supplier_address_id'] = null;
            $data['supplier_name'] = null;
            $data['supplier_address'] = null;
            $data['supplier_city'] = null;
            $data['supplier_zip_code'] = null;
            $data['supplier_country'] = null;
            return $data;
        }
        $partner = Partner::where('id', $supplier_id)->get()[0];
        $address = PartnerAddress::where('partner_id', $supplier_id)->where('id', $address_id)->get()[0];
        $data['supplier_id'] = $partner->id;
        $data['supplier_name'] = $partner->name;
        $data['supplier_address_id'] = $address->id;
        $data['supplier_address'] = $address->address;
        $data['supplier_city'] = $address->city;
        $data['supplier_zip_code'] = $address->zip_code;
        $data['supplier_country'] = $address->country;
        return $data;
    }
}
