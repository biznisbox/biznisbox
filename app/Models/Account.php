<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Account extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'type',
        'currency',
        'description',
        'opening_balance',
        'date_opened',
        'date_closed',
        'bank_name',
        'bank_address',
        'bank_contact',
        'iban',
        'bic',
        'is_default',
        'is_active',
        'open_banking_id',
        'integration',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'date_opened' => 'datetime',
        'date_closed' => 'datetime',
    ];

    protected $dates = ['date_opened', 'date_closed'];

    protected $hidden = ['open_banking_id', 'created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['current_balance'];

    public function generateTags(): array
    {
        return ['Bill'];
    }

    public function openBanking()
    {
        return $this->belongsTo(OpenBanking::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id', 'id')
            ->orWhere('from_account', $this->id)
            ->orWhere('to_account', $this->id)
            ->orderBy('date', 'desc');
    }

    public function createAccount($data)
    {
        if ($data['is_default'] == true) {
            $this->changeDefaultAccount();
        }
        $account = self::create($data);
        if ($account) {
            sendWebhookForEvent('account:created', $account->toArray());
            return true;
        }
        return false;
    }

    public function updateAccount($id, $data)
    {
        $account = self::where('id', $id)->first();
        if ($data['is_default'] == true) {
            $this->changeDefaultAccount();
        }
        $account->update($data);
        if ($account) {
            sendWebhookForEvent('account:updated', $account->toArray());
            return true;
        }
        return false;
    }

    public function deleteAccount($id)
    {
        $account = self::where('id', $id)->first();
        if ($account->is_default == 1) {
            return [
                'error' => true,
                'message' => __('responses.default_account_cannot_be_deleted'),
            ];
        }
        $account = $account->delete();
        if ($account) {
            sendWebhookForEvent('account:deleted', $account->toArray());
            return true;
        }
        return $account;
    }

    public function getAccount($id)
    {
        $account = self::where('id', $id)->first();
        $account->transactions;
        if ($account) {
            createActivityLog('retrieve', $id, 'App\Models\Account', 'Account');
            return $account;
        }
        return false;
    }

    public function getAccounts()
    {
        $accounts = $this->orderBy('name', 'asc')->get();
        if ($accounts) {
            createActivityLog('retrieve', null, 'App\Models\Account', 'Account');
            return $accounts;
        }
        return false;
    }

    private function changeDefaultAccount()
    {
        $account = $this->where('is_default', true)->update(['is_default' => false]);
        if ($account) {
            return true;
        }
        return false;
    }

    public function getCurrentBalanceAttribute()
    {
        $transactions = $this->transactions()->get();
        $balance = 0;

        foreach ($transactions as $transaction) {
            if ($transaction->date > $this->date_opened) {
                if ($transaction->type == 'income') {
                    $balance += $transaction->amount;
                } elseif ($transaction->type == 'expense') {
                    $balance -= $transaction->amount;
                } elseif ($transaction->type == 'transfer') {
                    if ($transaction->from_account == $this->id) {
                        $balance -= $transaction->amount;
                    } elseif ($transaction->to_account == $this->id) {
                        $balance += $transaction->amount;
                    }
                }
            }
        }

        return $balance + $this->opening_balance;
    }
}
