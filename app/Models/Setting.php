<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Setting extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Setting';

    protected $table = 'settings';

    protected $fillable = ['key', 'value', 'type', 'is_public'];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    public function generateTags(): array
    {
        return ['Settings'];
    }

    // For setting value attribute (automatically cast to correct type)
    public function getValueAttribute($value)
    {
        switch ($this->type) {
            case 'boolean':
                return (bool) $value;
            case 'integer':
                return (int) $value;
            case 'array':
                return json_decode($value, true);
            case 'object':
                return json_decode($value);
            default:
                return $value;
        }
    }

    // Get all settings as array
    public function getAllSettings()
    {
        $settings = self::all()->mapWithKeys(function ($item) {
            return [$item->key => $item->value];
        });
        createActivityLog('retrieve', null, Setting::$modelName, 'Setting');
        return $settings;
    }

    // Get all public settings as array (is_public = true) - for frontend
    public function getPublicSettings()
    {
        $settings = self::where('is_public', true)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->key => $item->value];
            });
        createActivityLog('retrieve', null, Setting::$modelName, 'Setting', null, null, 'public', 'public'); # there are errors in logs
        return $settings;
    }

    // Set setting value by key (if not exists, create new) or array of key => value
    public function set($key, $value = null, $type = 'string', $is_public = true)
    {
        if (is_array($key)) {
            foreach ($key as $name => $value) {
                self::set($name, $value);
            }
            return true;
        }
        $setting = self::updateOrCreate(['key' => $key], ['value' => $value]);
        if ($setting) {
            return true;
        }
        return false;
    }

    // Get setting value by key or default value if not exists
    public function get($key, $default = null)
    {
        if (self::has($key)) {
            return self::where('key', $key)->first()->value;
        }
        return $default;
    }

    // Check if setting exists by key
    public function has($key)
    {
        return self::where('key', $key)->exists();
    }

    // Remove setting by key
    public function remove($key)
    {
        if (self::has($key)) {
            return self::where('key', $key)->delete();
        }
        return false;
    }

    // Get more settings by keys
    public function only($keys)
    {
        foreach ($keys as $key) {
            $settings[$key] = self::get($key);
        }
        return $settings;
    }
}
