<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Settings extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'settings';

    protected $fillable = ['key', 'value', 'type', 'is_public'];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function generateTags(): array
    {
        return ['Settings'];
    }

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

    public function getAllSettings()
    {
        $settings = self::all()->mapWithKeys(function ($item) {
            return [$item->key => $item->value];
        });

        return $settings;
    }

    public function getPublicSettings()
    {
        $settings = self::where('is_public', true)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->key => $item->value];
            });
        return $settings;
    }

    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $name => $value) {
                self::set($name, $value);
            }
            return true;
        }

        $setting = self::where('key', $key)->first();
        if (!$setting) {
            $setting = self::create(['key' => $key, 'value' => $value, 'type' => 'string']);
        } else {
            $setting->update(['value' => $value]);
        }
    }

    public function get($key, $default = null)
    {
        if (self::has($key)) {
            return self::where('key', $key)->first()->value;
        }
        return $default;
    }

    public function has($key)
    {
        return self::where('key', $key)->exists();
    }

    public function remove($key)
    {
        if (self::has($key)) {
            return self::where('key', $key)->delete();
        }
        return false;
    }
}
