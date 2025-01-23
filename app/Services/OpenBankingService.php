<?php

namespace App\Services;

use App\Models\OpenBanking;
use Nordigen\NordigenPHP\API\NordigenClient;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class OpenBankingService
{
    private NordigenClient $client;
    private $config = [];

    public function __construct()
    {
        $this->config = settings(['open_banking_id', 'open_banking_secret', 'open_banking_available']);
        if ($this->config['open_banking_available']) {
            if (!$this->config['open_banking_id'] || !$this->config['open_banking_secret']) {
                return false;
            }
            $this->client = new NordigenClient($this->config['open_banking_id'], $this->config['open_banking_secret']);
            $this->client->createAccessToken();
        }
    }

    public function listAvailableCountries()
    {
        $countries = [
            ['name' => 'Austria', 'code' => 'AT'],
            ['name' => 'Belgium', 'code' => 'BE'],
            ['name' => 'Bulgaria', 'code' => 'BG'],
            ['name' => 'Croatia', 'code' => 'HR'],
            ['name' => 'Cyprus', 'code' => 'CY'],
            ['name' => 'Czech Republic', 'code' => 'CZ'],
            ['name' => 'Denmark', 'code' => 'DK'],
            ['name' => 'Estonia', 'code' => 'EE'],
            ['name' => 'Finland', 'code' => 'FI'],
            ['name' => 'France', 'code' => 'FR'],
            ['name' => 'Germany', 'code' => 'DE'],
            ['name' => 'Greece', 'code' => 'GR'],
            ['name' => 'Hungary', 'code' => 'HU'],
            ['name' => 'Ireland', 'code' => 'IE'],
            ['name' => 'Italy', 'code' => 'IT'],
            ['name' => 'Latvia', 'code' => 'LV'],
            ['name' => 'Lithuania', 'code' => 'LT'],
            ['name' => 'Luxembourg', 'code' => 'LU'],
            ['name' => 'Malta', 'code' => 'MT'],
            ['name' => 'Netherlands', 'code' => 'NL'],
            ['name' => 'Poland', 'code' => 'PL'],
            ['name' => 'Portugal', 'code' => 'PT'],
            ['name' => 'Romania', 'code' => 'RO'],
            ['name' => 'Slovakia', 'code' => 'SK'],
            ['name' => 'Slovenia', 'code' => 'SI'],
            ['name' => 'Spain', 'code' => 'ES'],
            ['name' => 'Sweden', 'code' => 'SE'],
            ['name' => 'United Kingdom', 'code' => 'GB'],
        ];
        return $countries;
    }

    public function listAvailableBanksByCountry(string $countryCode)
    {
        if ($this->config['open_banking_available']) {
            $banks = $this->client->institution->getInstitutionsByCountry($countryCode);
            // Sandbox bug in development -> for testing purposes
            if (config('app.debug')) {
                array_push($banks, [
                    'id' => 'SANDBOXFINANCE_SFIN0000',
                    'name' => 'Sandbox Finance',
                    'logo' => 'https://cdn.nordigen.com/ais/SANDBOXFINANCE_SFIN0000.png',
                ]);
            }
            return $banks;
        }
        return false;
    }

    public function getBankById($id)
    {
        if ($this->config['open_banking_available']) {
            if ($id) {
                $bank = $this->client->institution->getInstitution($id);
                return $bank;
            }
            return false;
        }
        return false;
    }

    public function initSession($redirectUri, $institutionId, $maxHistoricalDays = 90)
    {
        if ($this->config['open_banking_available']) {
            $bank = $this->getBankById($institutionId);
            $maxHistoricalDays = $bank['transaction_total_days'];
            if ($redirectUri && $institutionId) {
                $session = $this->client->initSession($institutionId, $redirectUri, $maxHistoricalDays);
                OpenBanking::create([
                    'bank_id' => $institutionId,
                    'requisition_id' => $session['requisition_id'],
                    'requisition_status' => 'PENDING',
                ]);
                return $session;
            }
            return false;
        }
        return false;
    }

    public function createOpenBankingAccount($requisitionId)
    {
        if ($this->config['open_banking_available'] && $requisitionId) {
            $session = $this->client->requisition->getRequisition($requisitionId);
            if ($session['status'] == 'LN') {
                $accounts = $session['accounts'];
                try {
                    DB::beginTransaction();
                    // Delete row from open_banking table
                    OpenBanking::where('requisition_id', $requisitionId)->delete();

                    foreach ($accounts as $account) {
                        // Get account details
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
                            'connection_status' => 'CONNECTED',
                            'transaction_total_days' => $bank['transaction_total_days'] ?? 90,
                            'connection_valid_until' => now()->addDays(90)->format('Y-m-d H:i:s'),
                        ]);

                        // Create internal account
                        $internal_account = Account::create([
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
                            'date_opened' => now()->format('Y-m-d'),
                            'currency' => $balance['balances'][0]['balanceAmount']['currency'] ?? settings('default_currency'),
                            'is_active' => 1,
                        ]);

                        // Create internal account transaction
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
                    DB::commit();
                    sendWebhookForEvent('open_banking:new_account_connected', $internal_account->toArray());
                    return true;
                } catch (\Exception $e) {
                    DB::rollBack();
                    return false;
                }
            }
            return false;
        }
        return false;
    }

    /**
     * Create transaction record
     * @param array $transaction_data (required)
     * @param UUID $account_id (optional)
     * @return void
     */
    private function createTransactionRecord($transaction_data, $account_id = null)
    {
        $transactionDescription =
            $transaction_data['remittanceInformationUnstructured'] ??
            ($transaction_data['remittanceInformationStructured'] ??
                ($transaction_data['remittanceInformationStructuredArray'][0] ??
                    ($transaction_data['remittanceInformationUnstructuredArray'][0] ?? null)));

        $transaction = Transaction::firstOrCreate(
            ['bank_transaction_id' => $transaction_data['transactionId'] ?? null],
            [
                'number' => generateNextNumber(settings('transaction_number_format'), 'transaction'),
                'bank_transaction_id' => $transaction_data['transactionId'] ?? null,
                'type' => $transaction_data['transactionAmount']['amount'] < 0 ? 'expense' : 'income',
                'amount' => str_replace('-', '', $transaction_data['transactionAmount']['amount']) ?? 0,
                'currency' => $transaction_data['transactionAmount']['currency'] ?? null,
                'date' => $transaction_data['bookingDate'] ?? null,
                'account_id' => $account_id,
                'exchange_rate' => $transaction_data['exchangeRate'] ?? 1,
                'name' => $transactionDescription ?? null,
                'description' => $transactionDescription ?? null,
                'status' => 'completed',
            ]
        );
        incrementLastItemNumber('transaction');
        return $transaction;
    }

    /**
     * Mark bank transactions as synced
     * @param $account_id - ID of the open banking account connection
     * @return void
     */
    private function markBankTransactionsAsSynced($account_id)
    {
        $openBanking = OpenBanking::where('id', $account_id)->first();
        if ($openBanking) {
            $openBanking->update([
                'last_transaction_sync' => now()->format('Y-m-d H:i:s'),
            ]);
            $openBanking->save();
        }
    }

    public function refreshBankTransactions()
    {
        if ($this->config['open_banking_available']) {
            $openBankingAccounts = OpenBanking::whereNotNull('account_id')->get();
            foreach ($openBankingAccounts as $openBanking) {
                $account = Account::where('open_banking_id', $openBanking['id'])->first();
                if ($account) {
                    $transactions = $this->client
                        ->account($openBanking['account_id'])
                        ->getAccountTransactions(
                            now()->subDays($openBanking['transaction_total_days'])->format('Y-m-d'),
                            now()->format('Y-m-d')
                        )['transactions']['booked'];
                    foreach ($transactions as $transaction) {
                        $this->createTransactionRecord($transaction, $account['id']);
                    }
                    $this->markBankTransactionsAsSynced($account['id']);
                }
            }
            sendWebhookForEvent('open_banking:transactions_refreshed', $openBankingAccounts->toArray());
            return true;
        }
        return false;
    }
}
