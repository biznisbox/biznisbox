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

    public static $modelName = 'App\Models\Account';

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
        return ['Account'];
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

    public static function changeDefaultAccount()
    {
        $account = self::where('is_default', true)->update(['is_default' => false]);
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
