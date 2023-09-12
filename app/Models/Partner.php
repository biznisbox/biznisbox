<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Partner extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

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
        'status',
    ];

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

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function getPartners($type = null)
    {
        if ($type) {
            return $this->with('addresses', 'contacts')->where('type', $type)->get();
        } else {
            return $this->with('addresses', 'contacts')->get();
        }
    }

    public function getPartner($id)
    {
        return $this->with('addresses', 'contacts')->where('id', $id)->first();
    }

    public function createPartner($data)
    {
        try{
            DB::beginTransaction();
            $partner = $this->create($data); // create partner
            if (isset($data['addresses'])) { // if addresses are sets
                foreach ($data['addresses'] as $address) {
                    $address['partner_id'] = $partner->id; // add partner id to address
                    processRelation($partner->addresses(), $data['addresses']);
                }
            }
    
            if (isset($data['contacts'])) { // if contacts are sets
                foreach ($data['contacts'] as $contact) {
                    $contact['partner_id'] = $partner->id; // add partner id to contact
                    processRelation($partner->contacts(), $data['contacts']);
                }
            }
            incrementLastItemNumber('partner');
            DB::commit();
            $partner = $this->getPartner($partner->id); // get partner with addresses and contacts
            return $partner;
        }
        catch(\Exception $e){
            DB::rollback();
            return false;
        }
    }


    public function updatePartner($id, $data){

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
                $partner = $this->getPartner($partner->id);
                return $partner;
            }
        }
        catch(\Exception $e){
            DB::rollback();
            return false;
        }
    }

    public function deletePartner($id)
    {
        try {
            $partner = $this->find($id);
            if ($partner) {
                $partner->delete();
                return true;
            }
        }
        catch(\Exception $e){
            return false;
        }
    }

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
        $number = generate_next_number(settings('partner_number_format'), 'partner');
        return $number;
    }
}

