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

    protected $fillable = ['number', 'created_by', 'vendor_id', 'status', 'date', 'due_date', 'discount', 'total'];

    protected $casts = [
        'date' => 'datetime',
        'due_date' => 'datetime',
        'discount' => 'float',
        'total' => 'float',
    ];
    public function generateTags(): array
    {
        return ['Bill'];
    }

    public function items()
    {
        return $this->hasMany(BillItems::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function getBills()
    {
        return $this->with(['items', 'vendor'])->get();
    }

    public function getBill($id)
    {
        return $this->with(['items', 'vendor'])->find($id);
    }

    public function createBill($data)
    {
        try {
            DB::beginTransaction();
            $bill = $this->create($data);

            if ($bill) {
                if (isset($data['items'])) {
                    foreach ($data['items'] as $item) {
                        $item['total'] = $this->calculateItemTotal($item);
                        $bill->items()->create($item);
                    }
                }

                $items = $bill->items()->get();

                $total = 0;
                foreach ($items as $item) {
                    $total += $item['total'];
                }

                if ($data['discount']) {
                    $total = $total - ($total * $data['discount']) / 100;
                }
                $bill->total = $total;
                $bill->save();
                incrementLastItemNumber('bill');
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function updateBill($id, $data)
    {
        try {
            DB::beginTransaction();

            $bill = $this->find($id);
            $bill->update($data);

            if ($bill) {
                if (isset($data['items'])) {
                    $bill->items()->delete();
                    foreach ($data['items'] as $item) {
                        $item['total'] = $this->calculateItemTotal($item);
                        $bill->items()->create($item);
                    }
                }

                $items = $bill->items()->get();

                $total = 0;
                foreach ($items as $item) {
                    $total += $item['total'];
                }

                if ($data['discount']) {
                    $total = $total - ($total * $data['discount']) / 100;
                }
                $bill->total = $total;
                $bill->save();
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
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

    protected function calculateItemTotal($item)
    {
        $total = $item['quantity'] * $item['price'];
        return $total;
    }
}
