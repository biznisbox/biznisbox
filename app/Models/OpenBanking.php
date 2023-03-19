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
        'name',
        'country',
        'currency',
        'bank_id',
        'iban',
        'bank_name',
        'bank_logo',
        'payments_available',
        'account_id',
        'requisition_id',
        'requisition_status',
        'connected_account_id',
        'connection_valid_until',
    ];

    protected $casts = [
        'payments_available' => 'boolean',
    ];

    protected $hidden = ['account_id', 'created_at', 'updated_at', 'requisition_id'];

    protected $dates = ['connection_valid_until'];

    public function generateTags(): array
    {
        return ['OpenBanking'];
    }

    public function account()
    {
        return $this->belongsTo(Accounts::class, 'open_banking_account_id', 'id');
    }

    public function updateAccount($id, $data)
    {
        $account = $this->find($id);
        if ($account) {
            $account->update([
                'name' => $data['name'] ?? $account->name,
            ]);
            return true;
        }
        return null;
    }
}
