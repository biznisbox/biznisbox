<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';

    protected $fillable = [
        'user_id',
        'user_type',
        'event',
        'auditable_id',
        'auditable_type',
        'old_values',
        'new_values',
        'url',
        'ip_address',
        'user_agent',
        'tags',
        'type',
        'external_key',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function externalKey()
    {
        return $this->hasOne(ExternalKey::class, 'key', 'external_key');
    }

    public function getActionTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Create new activity log
     *
     * @param string $user_id User ID
     * @param string $event Description of event
     * @param string $auditable_id ID of auditable item
     * @param string $auditable_type Type of auditable item (class name)
     * @param array $tags Tags for activity log
     * @param string $type Type of activity log (internal, external)
     * @param string $external_key External key for external access (if type is external)
     * @return void
     */
    public function createLog(
        $user_id = null,
        $event = null,
        $auditable_id = null,
        $auditable_type = null,
        $tags = null,
        $type = 'internal',
        $external_key = null,
    ) {
        self::create([
            'auditable_id' => $auditable_id,
            'auditable_type' => $auditable_type,
            'event' => $event,
            'url' => request()->fullUrl(),
            'ip_address' => request()->getClientIp(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => $user_id,
            'tags' => $tags,
            'type' => $type,
            'external_key' => $external_key,
        ]);
    }

    /**
     * Get activity log by external key
     *
     * @param string $external_key External key
     * @return void
     */
    public function getLogByExternalKey($external_key)
    {
        return self::where('external_key', $external_key)->first();
    }

    public function getLogsByItem($item_id, $item_type)
    {
        return self::where('auditable_id', $item_id)
            ->where('auditable_type', $item_type)
            ->get();
    }
}
