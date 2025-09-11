<?php

namespace App\Services;

use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ExternalKey;
use Illuminate\Support\Facades\Mail;
use App\Mail\Client\ContractNotification;

class ContractService
{
    private $contractModel;

    public function __construct()
    {
        $this->contractModel = new Contract();
    }

    public function getContracts()
    {
        $contracts = $this->contractModel->with('signers', 'category:id,name,color', 'partner:id,name,type,entity_type')->get();
        createActivityLog('retrieve', null, Contract::$modelName, 'Contract');
        return $contracts;
    }

    public function getContract($id)
    {
        $contract = $this->contractModel
            ->with('signers', 'category:id,name,color', 'partner:id,name,type,entity_type')
            ->where('id', $id)
            ->first();
        createActivityLog('retrieve', $id, Contract::$modelName, 'Contract');
        return $contract;
    }

    public function createContract($data)
    {
        $data['sha256'] = hash('sha256', $data['content']);
        $data['version'] = 1;
        $data['user_id'] = auth()->user()->id; // creator
        $data['number'] = $this->contractModel->getContractNumber();

        $contract = $this->contractModel->create($data);

        if (!$contract) {
            return null;
        }
        // Create signers
        if (isset($data['signers'])) {
            $i = 1;
            foreach ($data['signers'] as $signer) {
                $signer['sign_order'] = $i;
                $signer['custom_signer'] = true;
                if ($signer['user_id'] != null) {
                    $signer['custom_signer'] = false;
                }

                $contract->signers()->create($signer);
                $i++;
            }
            if ($contract->status == 'waiting_signers') {
                $this->sendContractToSigners($contract->id);
            }
        }
        sendWebhookForEvent('contract:created', $contract->toArray());
        incrementLastItemNumber('contract', settings('contract_number_format'));
        saveFilePdfToArchive(
            $this->getContractPdf($contract->id, 'attach'),
            $contract->number . '.pdf',
            Contract::$modelName,
            $contract->id,
            $contract->partner_id,
        );
        return $contract;
    }

    public function updateContract($id, $data)
    {
        $sha256 = hash('sha256', $data['content']);
        $contract = $this->contractModel->where('id', $id)->first();

        if (!$contract) {
            return null;
        }

        // If the contract is signed, by only one signer, it cannot be updated
        $signers = $contract->signers()->where('status', 'signed')->count();
        if ($contract->status == 'signed' || $signers >= 1 || $contract->status == 'rejected') {
            return [
                'error' => true,
                'message' => __('responses.cannot_update_signed_contract'),
            ];
        }

        // If the content has changed, increment the version
        if ($contract->sha256 != $sha256) {
            $version = $contract->version + 1;
        }

        $contract_update = $contract->update([
            'partner_id' => $data['partner_id'] ?? $contract->partner_id,
            'category_id' => $data['category_id'] ?? $contract->category_id,
            'contract_id' => $data['contract_id'] ?? $contract->contract_id,
            'type' => $data['type'] ?? $contract->type,
            'title' => $data['title'] ?? $contract->title,
            'description' => $data['description'] ?? $contract->description,
            'status' => $data['status'] ?? $contract->status,
            'content' => $data['content'] ?? $contract->content,
            'start_date' => $data['start_date'] ?? $contract->start_date,
            'end_date' => $data['end_date'] ?? $contract->end_date,
            'version' => $version ?? $contract->version,
            'signed_date' => $data['signed_date'] ?? $contract->signed_date,
            'date_for_signature' => $data['date_for_signature'] ?? $contract->date_for_signature,
            'notes' => $data['notes'] ?? $contract->notes,
            'sha256' => $sha256,
        ]);

        if (!$contract_update) {
            return [
                'error' => true,
                'message' => __('responses.error_updating_item'),
            ];
        }

        // Update signers
        if (isset($data['signers'])) {
            $contract->signers()->delete();
            $i = 1;
            foreach ($data['signers'] as $signer) {
                $signer['sign_order'] = $i;
                $signer['custom_signer'] = true;
                if ($signer['user_id'] != null) {
                    $signer['custom_signer'] = false;
                }
                $contract->signers()->create($signer);
                $i++;
            }
            if ($contract->status == 'waiting_signers') {
                $this->sendContractToSigners($id);
            }
        }

        sendWebhookForEvent('contract:updated', $contract->toArray());
        saveFilePdfToArchive(
            $this->getContractPdf($contract->id, 'attach'),
            $contract->number . '.pdf',
            Contract::$modelName,
            $contract->id,
            $contract->partner_id,
        );
        return $contract;
    }

    public function deleteContract($id)
    {
        $contract = $this->contractModel->where('id', $id)->first();

        if (
            $contract->status == 'signed' ||
            $contract->signers()->where('status', 'signed')->count() >= 1 ||
            $contract->status == 'rejected'
        ) {
            return [
                'error' => true,
                'message' => __('responses.cannot_delete_signed_contract'),
            ];
        }

        if (!$contract) {
            return null;
        }
        $contract->signers()->delete();
        $contract->delete();
        sendWebhookForEvent('contract:deleted', $contract->toArray());

        return $contract;
    }

    public function getContractNumber()
    {
        return $this->contractModel->getContractNumber();
    }

    public function getContractPdf($id, $type = 'stream')
    {
        $contract = $this->getContract($id);
        $settings = settings([
            'company_name',
            'company_address',
            'company_city',
            'company_zip',
            'company_country',
            'company_phone',
            'company_email',
            'company_vat',
            'company_logo',
            'show_barcode_on_documents',
            'default_currency',
        ]);
        $pdf = PDF::loadView('pdfs.contract', compact('contract', 'settings'));

        if ($type == 'attach') {
            return $pdf->output();
        }
        if ($type == 'download') {
            createActivityLog('downloadContract', $contract->id, Contract::$modelName, 'Contract');
            return $pdf->download('Contract ' . $contract->number . '.pdf');
        } else {
            createActivityLog('viewContract', $contract->id, Contract::$modelName, 'Contract');
            return $pdf->stream('Contract ' . $contract->number . '.pdf');
        }
    }

    /**
     * Share contract
     * @return void
     */
    public function shareContract($contract_id, $data)
    {
        $contract = $this->contractModel->where('id', $contract_id)->first();

        if (!$contract) {
            return null;
        }

        $external_key = generateExternalKey('contract', $contract->id, 'system', null, $data['email'] ?? null, $data['type'] ?? 'manual');
        $external_key_data = ExternalKey::where([
            'key' => $external_key,
            'module' => 'contract',
            'module_item_id' => $contract->id,
        ])->first();

        $local_url = 'client/contract/' . $contract->id . '?key=' . $external_key . '&lang=' . app()->getLocale();
        $url = url('/' . $local_url);

        if ($data) {
            if ($data['type'] == 'email') {
                Mail::to($data['email'])->send(new ContractNotification($contract, $url, null));
            }
        }

        return [
            'url' => $url,
        ];
    }

    public function sendContractToSigners($contract_id)
    {
        $contract = $this->contractModel->where('id', $contract_id)->first();

        if (!$contract || $contract->type == 'paper') {
            return null;
        }

        $signers = $contract->signers()->where('status', '!=', 'signed')->get();
        foreach ($signers as $signer) {
            $external_key = generateExternalKey('contract', $contract->id, 'system', null, $signer->signer_email, 'email');
            $external_key_data = ExternalKey::where([
                'key' => $external_key,
                'module' => 'contract',
                'module_item_id' => $contract->id,
            ])->first();
            $signer->update(['signer_external_key_id' => $external_key_data->id]);
            $local_url = 'client/contract/' . $contract->id . '?key=' . $external_key . '&lang=' . app()->getLocale();
            $url = url('/' . $local_url);
            if ($signer->user_id != null) {
                // notification for internal users
                createNotification($signer->user_id, 'ContractForSign', 'NewContractForSign', 'info', 'Sign', $local_url);
            }
            setEmailConfig();
            Mail::to($signer->signer_email, $signer->signer_name)->send(new ContractNotification($contract, $url, $signer));
        }
        return $contract;
    }
}
