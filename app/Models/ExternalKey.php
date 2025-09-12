<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class ExternalKey extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\ExternalKey';

    protected $fillable = [
        'module',
        'module_item_id',
        'key',
        'creation_method',
        'created_by',
        'expires_at',
        'used',
        'used_at',
        'recipient_type',
        'recipient_id',
    ];

    protected $dates = ['expires_at', 'used_at', 'created_at', 'updated_at'];

    protected function casts(): array
    {
        return [
            'used' => 'boolean',
        ];
    }

    public function generateTags(): array
    {
        return ['ExternalKey'];
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Create a new external key
     * @param string $module - module name
     * @param string $module_item_id - id of item in module
     * @param string $creation_method - manual, system
     * @param string $expires_at - date
     * @param string $recipient_type - email, phone
     * @param string $recipient_id - email, phone of recipient
     */
    public function createExternalKey(
        $module,
        $module_item_id,
        $creation_method = 'manual',
        $expires_at = null,
        $recipient_id = null,
        $recipient_type = null,
    ) {
        $external_key = $this->create([
            'module' => $module,
            'module_item_id' => $module_item_id,
            'key' => $this->generateKey(),
            'creation_method' => $creation_method,
            'created_by' => auth()->id(),
            'expires_at' => $expires_at,
            'used' => false,
            'recipient_type' => $recipient_type,
            'recipient_id' => $recipient_id,
        ]);

        if ($external_key) {
            return $external_key->key;
        }
    }

    /**
     * Generate random key
     * @return string
     */
    public function generateKey($length = 85)
    {
        $key = Str::random($length);
        if ($this->where('key', $key)->exists()) {
            return $this->generateKey();
        }
        return $key;
    }

    /**
     * Check if key is valid
     * @param string $key
     * @param string $module
     * @return bool
     */
    public function validateKey($key, $module)
    {
        $external_key = $this->where('key', $key)->where('module', $module)->first();

        if ($external_key) {
            $external_key = $external_key->update([
                'used' => true,
                'used_at' => now(),
            ]);
            return true;
        }
        return false;
    }

    /**
     * Get external key
     *
     * @param string $key
     * @param string $module
     * @return object|bool
     */
    public static function getExternalKey($key, $module)
    {
        $external_key = self::where('key', $key)->where('module', $module)->first();
        createActivityLog('retrieve', $external_key->id, ExternalKey::$modelName, 'ExternalKey');

        if ($external_key) {
            return $external_key;
        }
        return false;
    }
}
