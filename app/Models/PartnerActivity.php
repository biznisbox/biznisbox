<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class PartnerActivity extends Model implements Auditable
{
    use HasFactory, SoftDeletes, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\PartnerActivity';

    protected $fillable = [
        'partner_id',
        'partner_contact_id',
        'employee_id',
        'type',
        'subject',
        'location',
        'content',
        'priority',
        'start_date',
        'end_date',
        'duration',
        'status',
        'outcome',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'duration' => 'integer',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $hidden = ['deleted_at'];

    public function generateTags(): array
    {
        return ['PartnerActivity'];
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function partnerContact()
    {
        return $this->belongsTo(PartnerContact::class, 'partner_contact_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function getDurationAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return null;
        }
        return $this->start_date->diffInMinutes($this->end_date);
    }

    public function createPartnerActivity($data)
    {
        $this->create($data);

        return $this;
    }

    public function updatePartnerActivity($id, $data)
    {
        $activity = $this->find($id);

        if (!$activity) {
            return null;
        }

        $is_success = $activity->update($data);

        return $is_success ? $activity : null;
    }

    public function deletePartnerActivity($id)
    {
        $activity = $this->find($id);

        if (!$activity) {
            return null;
        }

        $is_success = $activity->delete();

        return $is_success ? $activity : null;
    }

    public function getPartnerActivity($id)
    {
        return $this->find($id);
    }

    public function getPartnerActivitiesByPartner($partner_id)
    {
        return $this->where('partner_id', $partner_id)->get();
    }
}
