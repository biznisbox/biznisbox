<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Http\Request;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\URL;

class Contract extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Contract';

    protected $fillable = [
        'user_id',
        'category_id',
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

    public static function getContractNumber()
    {
        return generateNextNumber(settings('contract_number_format'), 'contract');
    }

    public function getClientContract($id, $log = false)
    {
        $contract = $this->with(
            'partner:id,name,type,entity_type',
            'category:id,name,color',
            'signers:contract_id,sign_order,signature,signature_date_time,signature_ip,signature_user_agent,signer_email,signer_name,signer_phone,status',
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
            createActivityLog('retrievePublic', $id, Contract::$modelName, 'Contract');
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
            'status' => $data['sign_status'],
            'signature' => $data['sign_status'] == 'signed' ? $data['signature'] : null,
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

        if ($data['sign_status'] == 'rejected') {
            $contract->update(['status' => 'rejected']);
            createNotification(
                $contract->user_id,
                'RejectedContract',
                'ContractRejectedBySigner',
                'info',
                'view',
                'contracts/' . $contract->id,
            );
            sendWebhookForEvent('contract:rejected_by_signer', $contract->toArray());
        }

        if ($data['sign_status'] == 'signed') {
            createNotification(
                $contract->user_id,
                'SignedContract',
                'ContractSignedBySigner',
                'info',
                'view',
                'contracts/' . $contract->id,
            );
            $signers = $contract->signers()->where('status', '!=', 'signed')->get();

            if (count($signers) == 0) {
                $contract->update(['status' => 'signed', 'signed_date' => now()]);
                createNotification(
                    $contract->user_id,
                    'SignedContract',
                    'ContractSignedByAllSigners',
                    'info',
                    'view',
                    'contracts/' . $contract->id,
                );
                sendWebhookForEvent('contract:signed', $contract->toArray());
            }
            sendWebhookForEvent('contract:signed_by_signer', $contract->toArray());
        }

        return $contract;
    }

    public function checkIfSignerIsSignContract($contract_id, $external_key)
    {
        Contract::disableAuditing();
        $contract = $this->where('id', $contract_id)->first();
        $signer = $contract
            ->signers()
            ->where([
                'signer_external_key_id' => $external_key,
                'contract_id' => $contract_id,
            ])
            ->whereNotIn('status', ['signed', 'rejected'])
            ->first();
        Contract::enableAuditing();
        if ($signer) {
            return true;
        }
        return false;
    }

    /**
     * Update contract status cron
     * @return void
     */
    public static function updateContractStatusCron()
    {
        $contracts = self::where('status', '!=', 'signed')->get();
        foreach ($contracts as $contract) {
            if ($contract->date_for_signature < now()) {
                $contract->update(['status' => 'expired']);
            }
        }
    }
}
