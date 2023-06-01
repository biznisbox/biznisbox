<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class OpenBanking extends Model implements Auditable
{
    use HasFactory, HasUuids;

    protected $table = 'open_banking';
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'bank_id',
        'iban',
        'bank_name',
        'bank_logo',
        'payment_available',
        'agreement_id',
        'agreement_status',
        'account_id',
        'requisition_id',
        'requisition_status',
        'connection_valid_until',
        'last_transaction_sync',
    ];

    protected $hidden = [
        'account_id',
        'created_at',
        'updated_at',
        'requisition_id',
        'requisition_status',
        'agreement_id',
        'agreement_status',
    ];

    protected $dates = ['connection_valid_until', 'last_transaction_sync'];

    public function generateTags(): array
    {
        return ['OpenBanking'];
    }
}
