<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'customers';

    protected $fillable = [
        'internal_id',
        'number',
        'name',
        'type',
        'vat_number',
        'id_number',
        'currency',
        'language',
        'notes',
        'website',
        'email',
        'phone',
        'default_payment_method',
        'payment_terms',
    ];

    public function generateTags(): array
    {
        return ['Customer'];
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class)->orWhere('payer_id', $this->id);
    }

    public function estimates()
    {
        return $this->hasMany(Estimate::class)->orWhere('payer_id', $this->id);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Create a new customer
     * @param $data
     * @return bool true if success
     */

    public function createCustomer($data)
    {
        try {
            DB::beginTransaction();
            $customer = self::create($data);
            $customer->addresses()->createMany($data['addresses']);
            incrementLastItemNumber('customer');
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Update a customer
     * @param $id
     * @param $data
     * @return bool true if success
     */
    public function updateCustomer($id, $data)
    {
        try {
            DB::beginTransaction();
            $customer = $this->find($id);
            $customer = $customer->update($data);

            $customer = $this->find($id);

            if (isset($data['addresses']) && count($data['addresses']) > 0) {
                $customer->addresses()->delete();
                $customer->addresses()->createMany($data['addresses']);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Delete a customer
     * @param $id
     * @return bool true if success
     */
    public function deleteCustomer($id)
    {
        try {
            DB::beginTransaction();
            $this->where('id', $id)->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Get a customer
     * @param $id
     * @return array|bool customer data if success or false if failed
     */
    public function getCustomer($id)
    {
        try {
            $customer = $this->with([
                'addresses' => function ($query) {
                    $query->orderBy('type', 'asc');
                },
            ])
                ->where('id', $id)
                ->first();

            $customer->invoices = $customer->invoices()->get();
            $customer->estimates = $customer->estimates()->get();
            $customer->transactions = $customer->transactions()->get();
            activity_log(user_data()->data->id, 'get customer', $id, 'App\Models\Customer', 'getCustomer');
            return $customer;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get all customers
     * @return void customers data if success or false if failed
     */
    public function getCustomers()
    {
        try {
            $customers = $this->with([
                'addresses' => function ($query) {
                    $query->orderBy('type', 'asc');
                },
            ])->get();
            activity_log(user_data()->data->id, 'get customers', null, 'App\Models\Customer', 'getCustomers');
            return $customers;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCustomerNumber()
    {
        $number = generate_next_number(settings('customer_number_format'), 'customer');
        return $number;
    }
}
