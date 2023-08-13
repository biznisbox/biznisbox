<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Vendor extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'vendors';

    protected $fillable = ['name', 'type', 'vat_number', 'email', 'phone', 'website', 'currency', 'address', 'city', 'zip_code', 'country'];

    public function generateTags(): array
    {
        return ['Vendor'];
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function createVendor($data)
    {
        $vendor = $this->create($data);

        if ($vendor) {
            return true;
        }
        return false;
    }

    public function updateVendor($id, $data)
    {
        $vendor = $this->find($id);
        $vendor = $vendor->update($data);

        if ($vendor) {
            return true;
        }
        return false;
    }

    public function deleteVendor($id)
    {
        $vendor = $this->find($id);
        $vendor->delete();

        if ($vendor) {
            return true;
        }
        return false;
    }

    public function getVendor($id)
    {
        $vendor = $this->with('bills')->find($id);

        if ($vendor) {
            return $vendor;
        }
        return false;
    }

    public function getVendors()
    {
        $vendors = $this->all();

        if ($vendors) {
            return $vendors;
        }
        return false;
    }
}
