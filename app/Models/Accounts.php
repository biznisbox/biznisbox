<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Accounts extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'accounts';

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
    ];

    protected $appends = ['current_balance'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function generateTags(): array
    {
        return ['Accounts'];
    }

    protected $dates = ['deleted_at'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id', 'id')->orderBy('date', 'desc');
    }

    public function bank_connections()
    {
        return $this->hasMany(OpenBanking::class, 'id', 'open_banking_id');
    }

    public function createAccount($data)
    {
        if ($data['is_default'] == true) {
            $this->where('is_default', true)->update(['is_default' => false]);
        }
        $account = self::create($data);
        if ($account) {
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
            return true;
        }
        return false;
    }

    public function deleteAccount($id)
    {
        $account = self::where('id', $id)->first();
        if ($account->is_default == 1) {
            return false;
        }
        $account = $account->delete();
        return $account;
    }

    public function getAccount($id)
    {
        $account = self::with('transactions')
            ->where('id', $id)
            ->first();
        if ($account) {
            activity_log(user_data()->data->id, 'get account', $id, 'App\Models\Accounts', 'getAccount');
            return $account;
        }
        return false;
    }

    public function getAccounts()
    {
        $accounts = self::all();
        if ($accounts) {
            activity_log(user_data()->data->id, 'get accounts', null, 'App\Models\Accounts', 'getAccounts');
            return $accounts;
        }
        return false;
    }

    protected function changeDefaultAccount()
    {
        $account = $this->where('is_default', true)->update(['is_default' => false]);
        if ($account) {
            return true;
        }
        return false;
    }

    public function getCurrentBalanceAttribute()
    {
        $account = $this->find($this->id);
        if (!$account->date_opened) {
            // if date opened is null then return opening balance as current balance -> backward compatibility
            return $this->opening_balance;
        }
        $transactions = DB::table('transactions')
            ->where('account_id', $this->id)
            ->whereDate('date', '>=', $account->date_opened)
            ->get();
        $balance = $this->opening_balance;
        foreach ($transactions as $transaction) {
            if ($transaction->type == 'income') {
                $balance += $transaction->amount;
            }
            if ($transaction->type == 'expense') {
                $balance -= $transaction->amount;
            }
            if ($transaction->type == 'transfer') {
                if ($transaction->from_account == $account->id) {
                    $balance -= $transaction->amount;
                }
                if ($transaction->to_account == $account->id) {
                    $balance += $transaction->amount;
                }
            }
        }
        return $balance;
    }
}
