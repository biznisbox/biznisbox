<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class ContractSigner extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'contract_id',
        'employee_id',
        'signer_external_key_id',
        'custom_signer',
        'signer_name',
        'signer_email',
        'signer_phone',
        'signer_notes',
        'status',
        'sign_order',
        'signature',
        'signature_ip',
        'signature_user_agent',
        'signature_date_time',
        'notes',
    ];

    protected $casts = [
        'signature_date_time' => 'datetime',
        'custom_signer' => 'boolean',
    ];

    protected $dates = ['updated_at', 'created_at'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
