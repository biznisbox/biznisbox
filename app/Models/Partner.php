<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Log;

class Partner extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Partner';

    protected $table = 'partners';

    protected $fillable = [
        'assignee_id',
        'number',
        'type',
        'entity_type',
        'name',
        'vat_number',
        'language',
        'notes',
        'website',
        'size',
        'industry',
        'currency',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function generateTags(): array
    {
        return ['Partner'];
    }

    public function addresses()
    {
        return $this->hasMany(PartnerAddress::class);
    }

    public function contacts()
    {
        return $this->hasMany(PartnerContact::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'payer_id')->union($this->hasMany(Invoice::class, 'customer_id'));
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'payer_id')->union($this->hasMany(Quote::class, 'customer_id'));
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id')->union($this->hasMany(Transaction::class, 'supplier_id'));
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'supplier_id')->union($this->hasMany(Bill::class, 'customer_id'));
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function archiveDocuments()
    {
        return $this->hasMany(Archive::class);
    }

    public function activities()
    {
        return $this->hasMany(PartnerActivity::class)->orderBy('created_at', 'desc');
    }

    public function getPartners($type = null)
    {
        // type can have comma separated values (customer, supplier, both)
        if ($type) {
            $type = explode(',', $type);
            $partners = $this->with('addresses', 'contacts')->whereIn('type', $type)->get();
        } else {
            $partners = $this->with('addresses', 'contacts')->get();
        }
        createActivityLog('retrieve', null, Partner::$modelName, 'Partner');
        return $partners;
    }

    public function getPartner($id, $full = false)
    {
        $partner = $this->with(
            'addresses',
            'contacts',
            'invoices',
            'quotes',
            'transactions',
            'bills',
            'supportTickets',
            'archiveDocuments',
            'activities',
        )->find($id);
        if (!$partner) {
            return null;
        }
        createActivityLog('retrieve', $id, Partner::$modelName, 'Partner');
        return $partner;
    }

    /**
     * Create partner
     * @param $data - partner data
     */
    public function createPartner($data)
    {
        try {
            DB::beginTransaction();
            $partner = $this->create($data); // create partner
            if (isset($data['addresses'])) {
                // if addresses are sets
                foreach ($data['addresses'] as $address) {
                    $address['partner_id'] = $partner->id; // add partner id to address
                    processRelation($partner->addresses(), $data['addresses']);
                }
            }

            if (isset($data['contacts'])) {
                // if contacts are sets
                foreach ($data['contacts'] as $contact) {
                    $contact['partner_id'] = $partner->id; // add partner id to contact
                    processRelation($partner->contacts(), $data['contacts']);
                }
            }
            incrementLastItemNumber('partner', settings('partner_number_format'));
            DB::commit();
            $partner = $this->getPartner($partner->id); // get partner with addresses and contacts
            sendWebhookForEvent('partner:created', $partner->toArray());
            return $partner;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return false;
        }
    }

    /**
     * Update partner
     * @param $id - partner id
     * @param $data - partner data
     */
    public function updatePartner($id, $data)
    {
        try {
            DB::beginTransaction();
            $partner = $this->find($id);
            if ($partner) {
                $partner->fill($data)->save();
                if (isset($data['addresses'])) {
                    processRelation($partner->addresses(), $data['addresses']);
                }
                if (isset($data['contacts'])) {
                    processRelation($partner->contacts(), $data['contacts']);
                }
                DB::commit();
                $partner = $this->getPartner($partner->id);
                sendWebhookForEvent('partner:updated', $partner->toArray());
                return $partner;
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return false;
        }
    }

    /**
     * Delete partner
     * @param $id - partner id
     */
    public function deletePartner($id)
    {
        try {
            $partner = $this->find($id);
            if ($partner) {
                $partner->delete();
                sendWebhookForEvent('partner:deleted', $partner->toArray());
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Force delete partner
     * @param $id - partner id
     */

    public function forceDeletePartner($id)
    {
        $partner = $this->find($id);
        if ($partner) {
            $partner->forceDelete();
            $partner->addresses()->forceDelete();
            $partner->contacts()->forceDelete();
            return true;
        }
        return false;
    }

    public static function getPartnerNumber()
    {
        return generateNextNumber(settings('partner_number_format'), 'partner');
    }

    /**
     * Get partners limited data (used for select in forms) - provide only basic data and addresses
     * @param string|null $type - type of partner (customer, supplier, both)
     * @return array
     */
    public function getPartnersLimitedData($type = null)
    {
        $partners = $this->getPartners($type);
        $data = [];
        foreach ($partners as $partner) {
            $data[] = [
                'id' => $partner->id,
                'name' => $partner->name,
                'number' => $partner->number,
                'type' => $partner->type,
                'entity_type' => $partner->entity_type,
                'addresses' => $partner->addresses->toArray(),
                'contacts' => $partner->contacts->toArray(),
            ];
        }
        return $data;
    }

    public function getPartnerAddress($partner_id, $address_id)
    {
        $address = $this->find($partner_id)->addresses()->where('id', $address_id)->first();
        return $address;
    }
}
