<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;

class PartnerContact extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\PartnerContact';

    protected $table = 'partner_contacts';

    protected $fillable = [
        'partner_id',
        'user_id',
        'is_primary',
        'client_portal',
        'name',
        'function',
        'email',
        'phone_number',
        'mobile_number',
        'fax_number',
        'notes',
    ];

    protected $hidden = ['partner_id', 'created_at', 'updated_at'];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    public function generateTags(): array
    {
        return ['PartnerContact'];
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
