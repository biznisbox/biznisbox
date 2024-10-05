<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Http\Request;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class Contract extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'partner_id',
        'partner_address_id',
        'category_id',
        'number',
        'type',
        'title',
        'description',
        'status',
        'content',
        'start_date',
        'end_date',
        'version',
        'signed_date',
        'date_for_signature',
        'notes',
        'sha256',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'signed_date' => 'datetime',
        'date_for_signature' => 'datetime',
    ];

    protected $dates = ['deleted_at', 'updated_at', 'created_at'];

    protected $hidden = ['deleted_at'];

    protected $appends = ['preview', 'download'];

    public function getPreviewAttribute()
    {
        return URL::signedRoute('getContractPdf', [
            'id' => $this->id,
            'type' => 'preview',
        ]);
    }

    public function getDownloadAttribute()
    {
        return URL::signedRoute('getContractPdf', [
            'id' => $this->id,
            'type' => 'download',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function signers()
    {
        return $this->hasMany(ContractSigner::class);
    }

    public function generateTags(): array
    {
        return ['Contract'];
    }

    public function getContracts()
    {
        $contracts = $this->with('signers', 'partner:id,name,type,entity_type')->get();
        createActivityLog('retrieve', null, 'App\Models\Contract', 'Contract');
        return $contracts;
    }

    public function getContract($id)
    {
        $contract = $this->with('signers', 'partner:id,name,type,entity_type')->where('id', $id)->first();
        createActivityLog('retrieve', $id, 'App\Models\Contract', 'Contract');
        return $contract;
    }

    public function createContract($data)
    {
        $data['sha256'] = hash('sha256', $data['content']);
        $data['user_id'] = auth()->user()->id;
        $data['number'] = $this->getContractNumber();

        $contract = $this->create($data);

        if (!$contract) {
            return null;
        }
        // Create signers
        if (isset($data['signers'])) {
            $i = 1;
            foreach ($data['signers'] as $signer) {
                $signer['sign_order'] = $i;
                $contract->signers()->create($signer);
                $i++;
            }
            if ($contract->status == 'waiting_signers') {
                $this->sendContractToSigners($contract->id);
            }
        }
        incrementLastItemNumber('contract');
        return $contract;
    }

    public function updateContract($id, $data)
    {
        $sha256 = hash('sha256', $data['content']);

        $contract = $this->where('id', $id)->first();

        if (!$contract) {
            return null;
        }

        // If the contract is signed, by only one signer, it cannot be updated
        $signers = $contract->signers()->where('status', 'signed')->get();
        if ($contract->status == 'signed' && count($signers) >= 1) {
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
            foreach ($data['signers'] as $signer) {
                $contract->signers()->create($signer);
            }
            if ($contract->status == 'waiting_signers') {
                $this->sendContractToSigners($id);
            }
        }

        return $contract;
    }

    public function deleteContract($id)
    {
        $contract = $this->where('id', $id)->first();

        if ($contract->status == 'signed') {
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

        return $contract;
    }

    public function getContractNumber()
    {
        $number = generateNextNumber(settings('contract_number_format'), 'contract');
        return $number;
    }

    public function getClientContract($id, $log = false)
    {
        $contract = $this->with(
            'partner:id,name,type,entity_type',
            'signers:contract_id,sign_order,signature,signature_date_time,signature_ip,signature_user_agent,signer_email,signer_name,signer_phone,status'
        )
            ->select([
                'id',
                'number',
                'title',
                'description',
                'status',
                'start_date',
                'end_date',
                'version',
                'signed_date',
                'date_for_signature',
                'content',
            ])
            ->where('id', $id)
            ->first();
        if ($log) {
            createActivityLog('retrievePublic', $id, 'App\Models\Contract', 'Contract');
        }
        return $contract;
    }

    public function sendContractToSigners($contract_id)
    {
        $contract = $this->where('id', $contract_id)->first();

        if (!$contract) {
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
            $url = url('/client/contract/' . $contract->id . '?key=' . $external_key . '&lang=' . app()->getLocale());
            Mail::to($signer->signer_email)->send(new \App\Mail\Client\ContractNotification($contract, $url, $signer));
        }
        return $contract;
    }

    public function signContract($contract_id, $key_id, $data)
    {
        $request = Request::capture();
        $contract = $this->where('id', $contract_id)->first();

        if (!$contract) {
            return null;
        }

        $signer = $contract->signers()->where('signer_external_key_id', $key_id)->first();

        if (!$signer || $signer->status == 'signed') {
            return [
                'error' => true,
                'message' => __('responses.signer_not_found_or_already_signed'),
            ];
        }

        $signer_update = $signer->update([
            'status' => 'signed',
            'signature' => $data['signature'],
            'signature_ip' => $request->ip(),
            'signature_user_agent' => $request->userAgent(),
            'signature_date_time' => now(),
            'notes' => $data['notes'],
        ]);

        if (!$signer_update) {
            return [
                'error' => true,
                'message' => __('responses.error_signing_contract'),
            ];
        }

        $signers = $contract->signers()->where('status', '!=', 'signed')->get();

        createNotification($contract->user_id, 'SignedContract', 'ContractSignedBySigner', 'info', 'view', 'contracts/' . $contract->id);

        if (count($signers) == 0) {
            $contract->update(['status' => 'signed', 'signed_date' => now()]);
            createNotification(
                $contract->user_id,
                'SignedContract',
                'ContractSignedByAllSigners',
                'info',
                'view',
                'contracts/' . $contract->id
            );
        }

        return $contract;
    }

    public function checkIfSignerIsSignContract($contract_id, $external_key)
    {
        self::disableAuditing();
        $contract = $this->where('id', $contract_id)->first();
        $signer = $contract
            ->signers()
            ->where([
                'signer_external_key_id' => $external_key,
                'contract_id' => $contract_id,
            ])
            ->where('status', '!=', 'signed')
            ->first();
        self::enableAuditing();
        if ($signer) {
            return true;
        }
        return false;
    }
}