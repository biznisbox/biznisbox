<?php

namespace App\Services;

use App\Models\OpenBanking;
use App\Models\Accounts;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Nordigen\NordigenPHP\API\NordigenClient;
use Illuminate\Support\Facades\App;

class OpenBankingService
{
    private NordigenClient $client;
    public function __construct()
    {
        if (settings('open_banking_available')) {
            $secretId = settings('open_banking_id');
            $secretKey = settings('open_banking_secret');
            $this->client = new NordigenClient($secretId, $secretKey);
            $this->client->createAccessToken();
        }
    }

    public function getBanks($country)
    {
        if ($this->checkIfOpenBankingIsEnabled()) {
            if ($country) {
                $banks = $this->client->institution->getInstitutionsByCountry($country);
                if (App::environment(['local', 'dev'])) {
                    array_push($banks, [
                        'id' => 'SANDBOXFINANCE_SFIN0000',
                        'name' => 'Sandbox Finance',
                        'logo' => 'https://cdn.nordigen.com/ais/SANDBOXFINANCE_SFIN0000.png',
                    ]);
                }
                return api_response($banks);
            }
            return api_response(null, __('response.open_banking.country_required'), 400);
        }
        return api_response(null, __('response.open_banking.not_enabled'), 403);
    }

    public function getBankById($id)
    {
        $this->checkIfOpenBankingIsEnabled();
        if ($id) {
            $bank = $this->client->institution->getInstitution($id);
            return api_response($bank);
        }
        return api_response(null, __('response.open_banking.id_required'), 400);
    }

    public function initSession($redirectUri, $institutionId, $maxHistoricalDays = 90)
    {
        $this->checkIfOpenBankingIsEnabled();
        if ($redirectUri && $institutionId) {
            $session = $this->client->initSession($institutionId, $redirectUri, $maxHistoricalDays);
            OpenBanking::create([
                'bank_id' => $institutionId,
                'requisition_id' => $session['requisition_id'],
                'requisition_status' => 'PENDING',
            ]);
            return api_response($session);
        }
        return api_response(null, __('response.open_banking.not_provided_infos'), 400);
    }

    public function getRequisition($requisitionId)
    {
        if ($this->checkIfOpenBankingIsEnabled()) {
            if ($requisitionId) {
                try {
                    DB::beginTransaction();
                    $session = $this->client->requisition->getRequisition($requisitionId);
                    if ($session['status'] == 'LN') {
                        $accounts = $session['accounts'];
                        $openBanking = OpenBanking::where('requisition_id', $requisitionId)->delete();
                        foreach ($accounts as $account) {
                            $account = $this->client->account($account);
                            $accountData = $account->getAccountMetaData();
                            $bank = $this->client->institution->getInstitution($accountData['institution_id']);
                            $balance = $account->getAccountBalances();
                            $openBanking = OpenBanking::create([
                                'bank_id' => $accountData['institution_id'],
                                'requisition_id' => $requisitionId,
                                'requisition_status' => 'SUCCESS',
                                'agreement_id' => $session['agreement'],
                                'agreement_status' => 'ACCEPTED',
                                'account_id' => $accountData['id'],
                                'iban' => $accountData['iban'] ?? null,
                                'currency' => $accountData['currency'] ?? null,
                                'bank_name' => $bank['name'] ?? null,
                                'payment_available' => json_encode($bank['supported_payments']) ?? false,
                                'bank_logo' => $bank['logo'] ?? null,
                                'connection_valid_until' => now()
                                    ->addDays(90)
                                    ->format('Y-m-d H:i:s'),
                            ]);

                            // Create internal account
                            $internal_account = Accounts::create([
                                'name' => $accountData['iban'] ?? null,
                                'type' => 'bank_account',
                                'currency' => $accountData['currency'] ?? null,
                                'bank_name' => $bank['name'] ?? null,
                                'iban' => $accountData['iban'] ?? null,
                                'bic' => $bank['bic'] ?? null,
                                'currency' => $accountData['currency'] ?? null,
                                'open_banking_id' => $openBanking['id'],
                                'integration' => 'open_banking',
                                'opening_balance' => $balance['balances'][0]['balanceAmount']['amount'] ?? 0,
                                'current_balance' => $balance['balances'][0]['balanceAmount']['amount'] ?? 0,
                                'currency' => $balance['balances'][0]['balanceAmount']['currency'] ?? settings('default_currency'),
                                'is_active' => 1,
                            ]);

                            $transactions = $account->getAccountTransactions(
                                now()
                                    ->subDays($bank['transaction_total_days'] ?? 90)
                                    ->format('Y-m-d'),
                                now()->format('Y-m-d')
                            )['transactions']['booked'];

                            foreach ($transactions as $transaction) {
                                $this->createTransactionRecord($transaction, $internal_account['id']);
                            }
                            $this->markBankTransactionsAsSynced($internal_account['id']);
                        }
                    }
                    DB::commit();
                    return api_response($session, __('response.open_banking.requisition_success'), 200);
                } catch (\Exception $e) {
                    DB::rollback();
                    return api_response(null, __('response.open_banking.requisition_error'), 400);
                }
            }
        }
    }

    protected function checkIfOpenBankingIsEnabled()
    {
        if (settings('open_banking_available')) {
            return true;
        }
        return false;
    }

    public function refreshConnection($id)
    {
        if ($this->checkIfOpenBankingIsEnabled()) {
            if ($id) {
                $openBanking = OpenBanking::where('id', $id)->first();
                if ($openBanking) {
                }
            }
            return api_response(null, __('response.open_banking.not_enabled'), 403);
        }
    }

    public function refreshBankTransactions()
    {
        if ($this->checkIfOpenBankingIsEnabled()) {
            try {
                DB::beginTransaction();
                $openBanking = OpenBanking::where('requisition_status', 'SUCCESS')->get();
                foreach ($openBanking as $bank) {
                    $accountBank = $this->client->account($bank->account_id);
                    $balance = $accountBank->getAccountBalances();
                    $account = Accounts::where('open_banking_id', $bank->id)->first();
                    if ($account->current_balance != $balance['balances'][0]['balanceAmount']['amount']) {
                        $transactions = $accountBank->getAccountTransactions(
                            Carbon::parse($bank->last_transaction_sync)->format('Y-m-d'),
                            now()->format('Y-m-d')
                        )['transactions']['booked'];
                        $transactions_amount = 0;
                        foreach ($transactions as $transaction) {
                            $transactions_amount += $transaction['transactionAmount']['amount'];
                            $this->createTransactionRecord($transaction, $account['id']);
                        }

                        if ($transactions_amount + $account->current_balance != $balance['balances'][0]['balanceAmount']['amount']) {
                            DB::rollback();
                            return false;
                        }

                        $account->update([
                            'current_balance' => $balance['balances'][0]['balanceAmount']['amount'] ?? 0,
                        ]);
                        $account->save();

                        $this->markBankTransactionsAsSynced($bank->account_id);
                        DB::commit();
                        return true;
                    }
                    return true;
                }
            } catch (\Exception $e) {
                DB::rollback();
                return false;
            }
        }
    }

    protected function createTransactionRecord($transaction_data, $account_id = null)
    {
        try {
            DB::beginTransaction();
            $transactionDescription =
                $transaction_data['remittanceInformationUnstructured'] ??
                ($transaction_data['remittanceInformationStructured'] ??
                    ($transaction_data['remittanceInformationStructuredArray'][0] ??
                        ($transaction_data['remittanceInformationUnstructuredArray'][0] ?? null)));

            $transaction = Transaction::create([
                'number' => generate_next_number(settings('transaction_number_format'), 'transactions'),
                'type' => $transaction_data['transactionAmount']['amount'] < 0 ? 'expense' : 'income',
                'amount' => str_replace('-', '', $transaction_data['transactionAmount']['amount']) ?? 0,
                'currency' => $transaction_data['transactionAmount']['currency'] ?? null,
                'date' => $transaction_data['bookingDate'] ?? null,
                'account_id' => $account_id ?? null,
                'exchange_rate' => $transaction_data['exchangeRate'] ?? 1,
                'name' => $transactionDescription ?? null,
                'description' => $transactionDescription ?? null,
                'status' => 'COMPLETED',
            ]);
            incrementLastItemNumber('transactions');
            DB::commit();
            return $transaction;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    protected function markBankTransactionsAsSynced($account_id)
    {
        $account = Accounts::where('id', $account_id)->first();

        if ($account) {
            $openBanking = OpenBanking::where('id', $account->open_banking_id)->first();
            if ($openBanking) {
                $openBanking->last_transaction_sync = now();
                $openBanking->save();
            }
        }
    }
}
