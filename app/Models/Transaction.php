<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Transaction extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Transaction';

    protected $fillable = [
        'invoice_id',
        'bill_id',
        'customer_id',
        'supplier_id',
        'account_id',
        'category_id',
        'payment_id',
        'bank_transaction_id',
        'number',
        'type',
        'from_account',
        'to_account',
        'name',
        'description',
        'amount',
        'currency',
        'exchange_rate',
        'payment_method_id',
        'reference',
        'status',
        'date',
        'reconciled',
        'reconciled_at',
    ];

    protected $casts = [
        'amount' => 'double',
        'exchange_rate' => 'double',
        'date' => 'datetime',
        'reconciled' => 'boolean',
        'reconciled_at' => 'datetime',
    ];

    protected $dates = ['date', 'reconciled_at', 'created_at', 'updated_at', 'deleted_at', 'date_opened', 'date_closed'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function generateTags(): array
    {
        return ['Transaction'];
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(OnlinePayment::class, 'payment_id', 'id');
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
            createActivityLog('retrieve', null, Transaction::$modelName, 'Transaction');
            return $transactions;
        }
        return false;
    }

    public function getTransaction($id)
    {
        $transaction = $this->with([
            'account',
            'category',
            'invoice',
            'bill',
            'customer',
            'supplier',
            'payment:number,id,payment_method,amount,currency',
        ])->find($id);
        if ($transaction) {
            createActivityLog('retrieve', $id, Transaction::$modelName, 'Transaction');
            return $transaction;
        }
        return false;
    }

    public function createTransaction($data)
    {
        $data = $this->setTransactionLogic($data);
        $data['number'] = self::getTransactionNumber();

        $transaction = $this->create($data);
        if ($transaction) {
            incrementLastItemNumber('transaction', settings('transaction_number_format'));
            sendWebhookForEvent('transaction:created', $transaction->toArray());
            return $transaction;
        }
        return false;
    }

    public function updateTransaction($id, $data)
    {
        $data = $this->setTransactionLogic($data);
        $transaction = $this->find($id);
        if (!$transaction) {
            return false;
        }

        $data['number'] = $transaction->number;
        $transaction = $transaction->update($data);
        if ($transaction) {
            $transaction = $this->find($id);
            sendWebhookForEvent('transaction:updated', $transaction->toArray());
            return $transaction;
        }
        return false;
    }

    public function deleteTransaction($id)
    {
        $transaction = $this->where('id', $id)->delete();
        if ($transaction) {
            sendWebhookForEvent('transaction:deleted', ['id' => $id]);
            return $transaction;
        }
        return false;
    }

    public static function getTransactionNumber()
    {
        $number = generateNextNumber(settings('transaction_number_format'), 'transaction');
        return $number;
    }

    public function getTransactionsByAccountId($account_id)
    {
        $transactions = $this->where('account_id', $account_id)->get();
        if ($transactions) {
            createActivityLog('retrieve', null, Transaction::$modelName, 'Transaction');
            return $transactions;
        }
        return false;
    }

    private function setTransactionLogic($data)
    {
        if ($data['type'] == 'expense') {
            $data['from_account'] = $data['account_id'];
        } elseif ($data['type'] == 'income') {
            $data['to_account'] = $data['account_id'];
        }

        if ($data['type'] == 'expense') {
            $data['invoice_id'] = null;
            $data['customer_id'] = null;
        }

        if ($data['type'] == 'income') {
            $data['bill_id'] = null;
            $data['supplier_id'] = null;
        }

        if ($data['type'] == 'transfer') {
            $data['customer_id'] = null;
            $data['supplier_id'] = null;
        }
        if ($data['type'] == 'transfer') {
            $data['from_account'] = $data['account_id'];
            $data['to_account'] = $data['to_account'];
        }

        return $data;
    }
}
