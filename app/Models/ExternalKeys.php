<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;

class ExternalKeys extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'external_keys';

    protected $fillable = ['module', 'module_item_id', 'key', 'creation_method', 'created_by', 'expires_at', 'used', 'used_at'];

    protected $casts = [
        'used' => 'boolean',
    ];

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
     *
     * @param string $module
     * @param string $module_item_id
     */
    public function createExternalKey($module, $module_item_id, $creation_method = 'manual', $expires_at = null)
    {
        $external_key = $this->create([
            'module' => $module,
            'module_item_id' => $module_item_id,
            'key' => $this->generateKey(),
            'creation_method' => $creation_method,
            'created_by' => user_data()->data->id,
            'expires_at' => $expires_at,
        ]);

        if ($external_key) {
            return $external_key->key;
        }
    }

    /**
     * Generate random key
     *
     * @return string
     */
    public function generateKey($length = 80)
    {
        $key = Str::random($length);
        if ($this->where('key', $key)->exists()) {
            return $this->generateKey();
        }
        return $key;
    }

    /**
     * Check if key is valid
     *
     * @param string $key
     * @param string $module
     * @return bool
     */
    public function validateKey($key, $module)
    {
        $external_key = $this->where('key', $key)
            ->where('module', $module)
            ->first();

        if ($external_key) {
            $external_key->used = true;
            $external_key->used_at = now();
            $external_key->save();
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
    public function getExternalKey($key, $module)
    {
        $external_key = $this->where('key', $key)
            ->where('module', $module)
            ->limit(1)
            ->get();

        if ($external_key) {
            return $external_key[0];
        }
        return false;
    }
}
