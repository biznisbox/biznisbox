<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class PartnerContact extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'partner_contacts';

    protected $fillable = [
        'partner_id',
        'is_primary',
        'name',
        'function',
        'email',
        'phone_number',
        'mobile_number',
        'fax_number',
        'notes'
    ];

    public function generateTags(): array
    {
        return ['PartnerContact'];
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}