<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class PartnerAddress extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\PartnerAddress';

    protected $table = 'partner_addresses';

    protected $fillable = ['partner_id', 'is_primary', 'type', 'address', 'city', 'zip_code', 'country', 'notes'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    public function generateTags(): array
    {
        return ['PartnerAddress'];
    }

    public function formatAddresses()
    {
        return $this->address . ', ' . $this->zip_code . ' ' . $this->city . ', ' . $this->country;
    }

    public function getPartnerAddresses($partnerId)
    {
        return $this->where('partner_id', $partnerId)->get();
    }

    public function getPartnerAddress($id)
    {
        return $this->find($id);
    }

    public function createPartnerAddress($data)
    {
        return $this->create($data);
    }

    public function updatePartnerAddress($id, $data)
    {
        return $this->find($id)->update($data);
    }

    public function deletePartnerAddress($id)
    {
        return $this->find($id)->delete();
    }
}
