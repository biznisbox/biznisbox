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
        'bank_transaction_id', // bank transaction id from bank connection (e.g. 1234567890)
        'invoice_id',
        'payment_id',
        'bill_id',
        'customer_id',
        'supplier_id',
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
        return $this->belongsTo(Partner::class, 'customer_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Partner::class, 'supplier_id', 'id');
    }

    public function getTransactions()
    {
        $transactions = $this->with('account')->orderBy('date', 'desc')->get();
        if ($transactions) {
            activity_log(user_data()->data->id, 'get transactions', null, 'App\Models\Transaction', 'getTransactions');
            return $transactions;
        }
        return false;
    }

    public function getTransaction($id)
    {
        $transaction = $this->with(['account', 'category', 'invoice', 'payment', 'bill', 'customer', 'supplier'])->find($id);
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
                'getTransactionByInvoiceId',
            );
            return $transaction;
        }
        return false;
    }

    public function createTransaction($data)
    {
        $data['number'] = self::getTransactionNumber();
        $transaction = self::create($data);
        if ($transaction) {
            incrementLastItemNumber('transaction');
            return $transaction;
        }
        return false;
    }

    public function updateTransaction($id, $data)
    {
        $transaction = $this->find($id);
        $data['number'] = $transaction->number; // keep the same number - do not change it
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

    public static function getTransactionNumber()
    {
        $number = generate_next_number(settings('transaction_number_format'), 'transaction');
        return $number;
    }

    public function getTransactionsByAccountId($account_id)
    {
        $transactions = $this->where('account_id', $account_id)->get();
        if ($transactions) {
            activity_log(
                user_data()->data->id,
                'get transactions by account id',
                $account_id,
                'App\Models\Transaction',
                'getTransactionsByAccountId',
            );
            return $transactions;
        }
        return false;
    }
}
