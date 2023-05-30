<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
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
        'current_balance',
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

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function generateTags(): array
    {
        return ['Accounts'];
    }

    protected $dates = ['deleted_at'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id', 'id');
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
        $data['current_balance'] = $data['opening_balance'];
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

        $account->delete();
        if ($account) {
            return true;
        }
        return false;
    }

    public function getAccount($id)
    {
        $account = self::with('transactions')->find($id);
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

    protected function setCurrentBalance($opening_balance)
    {
        return $opening_balance;
    }
}
