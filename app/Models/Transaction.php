<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Accounts;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'transactions';

    protected $fillable = [
        'name',
        'invoice_id',
        'payment_id',
        'bill_id',
        'customer_id',
        'vendor_id',
        'account_id',
        'category_id',
        'number',
        'type',
        'description',
        'amount',
        'currency',
        'exchange_rate',
        'payment_method',
        'reference',
        'date',
        'reconciled',
        'reconciled_at',
    ];

    protected $casts = [
        'date' => 'datetime',
        'reconciled_at' => 'datetime',
    ];

    public function generateTags(): array
    {
        return ['Transaction'];
    }

    public function account()
    {
        return $this->belongsTo(Accounts::class, 'account_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(OnlinePayment::class, 'payment_id', 'id');
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function getTransactions()
    {
        $transactions = $this->with('account')
            ->orderBy('date', 'desc')
            ->get();
        if ($transactions) {
            activity_log(user_data()->data->id, 'get transactions', null, 'App\Models\Transaction', 'getTransactions');
            return $transactions;
        }
        return false;
    }

    public function getTransaction($id)
    {
        $transaction = $this->with(['account', 'category', 'invoice', 'payment', 'bill', 'customer', 'vendor'])->find($id);
        if ($transaction) {
            activity_log(user_data()->data->id, 'get transaction', $id, 'App\Models\Transaction', 'getTransaction');
            return $transaction;
        }
        return false;
    }

    public function getTransactionByInvoiceId($invoice_id)
    {
        $transaction = $this->where('invoice_id', $invoice_id)->first();
        if ($transaction) {
            activity_log(
                user_data()->data->id,
                'get transaction by invoice id',
                $invoice_id,
                'App\Models\Transaction',
                'getTransactionByInvoiceId'
            );
            return $transaction;
        }
        return false;
    }

    public function createTransaction($data)
    {
        if ($data['type'] == 'income') {
            $this->updateAccountAmount($data['account_id'], $data['amount'], $data['type']);
        }
        if ($data['type'] == 'expense') {
            $this->updateAccountAmount($data['account_id'], $data['amount'], $data['type']);
        }
        if ($data['type'] == 'transfer') {
            $this->transferAmount($data['from_account'], $data['to_account'], $data['amount']);
        }
        $transaction = self::create($data);
        incrementLastItemNumber('transaction');
        if ($transaction) {
            return $transaction;
        }
        return false;
    }

    public function updateTransaction($id, $data)
    {
        $transaction = $this->find($id);
        $transaction = $transaction->update($data);
        if ($transaction) {
            return $transaction;
        }
        return false;
    }

    public function deleteTransaction($id)
    {
        $transaction = $this->where('id', $id)->delete();
        if ($transaction) {
            return $transaction;
        }
        return false;
    }

    // TODO - need to first increase the amount in the account and then decrease the amount in the account (update the account amount)
    protected function updateAccountAmount($account_id, $amount, $type)
    {
        $account = Accounts::find($account_id);
        if ($account) {
            if ($type == 'income') {
                $account->current_balance = $account->current_balance + $amount;
            } else {
                $account->current_balance = $account->current_balance - $amount;
            }
            $account->save();
        }
    }

    // TODO - need to check if the amount is available in the from account before transfer and also need to check if the from and to account is same or not
    protected function transferAmount($from_account_id, $to_account_id, $amount)
    {
        $from_account = Accounts::where('id', $from_account_id)->first();
        $to_account = Accounts::where('id', $to_account_id)->first();
        if ($from_account && $to_account) {
            $from_account->current_balance = $from_account->current_balance - $amount;
            Transaction::create([
                'number' => $this->getTransactionNumber(),
                'account_id' => $from_account_id,
                'type' => 'expense',
                'category' => 'transfer',
                'description' => 'Transfer to ' . $to_account->name,
                'amount' => $amount,
                'currency' => $from_account->currency,
                'currency_rate' => 1,
                'payment_method' => 'transfer',
                'date' => now(),
            ]);
            $from_account->save();
            $to_account->current_balance = $to_account->current_balance + $amount;
            Transaction::create([
                'number' => $this->getTransactionNumber(),
                'account_id' => $to_account_id,
                'type' => 'income',
                'category' => 'transfer',
                'description' => 'Transfer from ' . $from_account->name,
                'amount' => $amount,
                'currency' => $to_account->currency,
                'currency_rate' => 1,
                'payment_method' => 'transfer',
                'date' => now(),
            ]);
            $to_account->save();
        }
    }

    public static function getTransactionNumber()
    {
        $number = generate_next_number(settings('transaction_number_format'), 'transactions');
        return $number;
    }
}
