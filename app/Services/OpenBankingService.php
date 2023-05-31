<?php

namespace App\Services;

use App\Models\OpenBanking;
use App\Models\Accounts;
use App\Models\Transaction;
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
                        );

                        foreach ($transactions as $transaction) {
                            foreach ($transaction['booked'] as $bookedTransaction) {
                                // Get transaction description
                                $transactionDescription =
                                    $bookedTransaction['remittanceInformationUnstructured'] ??
                                    ($bookedTransaction['remittanceInformationStructured'] ??
                                        ($bookedTransaction['remittanceInformationStructuredArray'][0] ??
                                            ($bookedTransaction['remittanceInformationUnstructuredArray'][0] ?? null)));

                                Transaction::create([
                                    'name' => $transactionDescription ?? null,
                                    'account_id' => $internal_account['id'],
                                    'number' => generate_next_number(settings('transaction_number_format'), 'transactions'),
                                    'type' => $bookedTransaction['transactionAmount']['amount'] < 0 ? 'expense' : 'income',
                                    'amount' => str_replace('-', '', $bookedTransaction['transactionAmount']['amount']),
                                    'currency' => $bookedTransaction['transactionAmount']['currency'],
                                    'date' => $bookedTransaction['bookingDate'] ?? now()->format('Y-m-d'),
                                    'description' => $transactionDescription,
                                    'status' => 'completed',
                                ]);
                                incrementLastItemNumber('transactions');
                            }
                        }
                    }
                    return api_response($session, __('response.open_banking.requisition_success'), 200);
                }
                return api_response($session, __('response.open_banking.requisition_failed'), 200);
            }
            return api_response(null, __('response.open_banking.session_id_required'), 400);
        }
        return api_response(null, __('response.open_banking.not_enabled'), 403);
    }

    protected function getAccount($accountId)
    {
        if ($this->checkIfOpenBankingIsEnabled()) {
            if ($accountId) {
                $account = $this->client->account($accountId);
                $accountData = $account->getAccountMetaData();
                activity_log(user_data()->data->id, 'get account', $accountId, 'App\Services\OpenBankingService', 'getAccount');
                return $accountData;
            }
            return null;
        }
    }

    protected function getAccountBalance($accountId)
    {
        if ($this->checkIfOpenBankingIsEnabled()) {
            if ($accountId) {
                $account = $this->client->account($accountId);
                $balance = $account->getAccountBalances();
                activity_log(
                    user_data()->data->id,
                    'get account balance',
                    $accountId,
                    'App\Services\OpenBankingService',
                    'getAccountBalance'
                );
                return $balance['balances'];
            }
            return null;
        }
    }

    protected function getAccountTransactions($accountId, $fromDate = null, $toDate = null)
    {
        if ($this->checkIfOpenBankingIsEnabled()) {
            if ($accountId) {
                $account = $this->client->account($accountId);
                $transactions = $account->getAccountTransactions($fromDate, $toDate);
                activity_log(
                    user_data()->data->id,
                    'get account transactions',
                    $accountId,
                    'App\Services\OpenBankingService',
                    'getAccountTransactions'
                );
                return $transactions['transactions'];
            }
            return null;
        }
        return null;
    }

    public function getAccounts()
    {
        if ($this->checkIfOpenBankingIsEnabled()) {
            $accounts = OpenBanking::where('requisition_status', 'SUCCESS')->get();
            return api_response($accounts);
        }
        return api_response(null, __('response.open_banking.not_enabled'), 403);
    }

    public function getAccountData($accountId, $fromDate = null, $toDate = null)
    {
        if ($this->checkIfOpenBankingIsEnabled()) {
            if ($accountId) {
                $openBanking = OpenBanking::where('id', $accountId)->first();
                if ($openBanking) {
                    $account = $this->getAccount($openBanking->account_id);
                    $balance = $this->getAccountBalance($openBanking->account_id);
                    $transactions = $this->getAccountTransactions($openBanking->account_id, $fromDate, $toDate);
                    $data = [
                        'internal_data' => $openBanking,
                        'account' => $account,
                        'balance' => $balance,
                        'transactions' => $transactions,
                    ];
                    activity_log(
                        user_data()->data->id,
                        'get account data',
                        $accountId,
                        'App\Services\OpenBankingService',
                        'getAccountData'
                    );
                    return api_response($data);
                }
                return api_response(null, __('response.open_banking.account_id_required'), 400);
            }
            return api_response(null, __('response.open_banking.account_id_required'), 400);
        }
        return api_response(null, __('response.open_banking.not_enabled'), 403);
    }

    public function updateAccount($id, $data)
    {
        if ($this->checkIfOpenBankingIsEnabled()) {
            if ($id) {
                $openBanking = OpenBanking::where('id', $id)->first();
                if ($openBanking) {
                    $openBanking = $openBanking->updateAccount($id, $data);
                    activity_log(user_data()->data->id, 'update account', $id, 'App\Services\OpenBankingService', 'updateAccount');
                    return api_response(null, __('response.open_banking.account_updated'), 200);
                }
                return api_response(null, __('response.open_banking.not_found'), 400);
            }
            return api_response(null, __('response.open_banking.not_found'), 400);
        }
        return api_response(null, __('response.open_banking.not_enabled'), 403);
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
}
