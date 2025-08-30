<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class OpenBanking extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\OpenBanking';

    protected $table = 'open_banking';
    protected $fillable = [
        'bank_id',
        'iban',
        'bank_name',
        'bank_logo',
        'payment_available',
        'account_id',
        'agreement_id',
        'agreement_status',
        'requisition_id',
        'requisition_status',
        'connection_valid_until',
        'last_transaction_sync',
    ];

    protected $casts = [
        'connection_valid_until' => 'datetime',
        'last_transaction_sync' => 'datetime',
    ];

    protected $hidden = ['id', 'created_at', 'updated_at', 'agreement_id', 'requisition_id'];

    public function generateTags(): array
    {
        return ['OpenBanking'];
    }
}
