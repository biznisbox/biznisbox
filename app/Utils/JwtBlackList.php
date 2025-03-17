<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Storage as StorageContract;

class JwtBlackList implements StorageContract
{
    const TABLE_NAME = 'jwt_black_list';

    /**
     * Add a new item into storage.
     *
     * @param string $key
     * @param int    $minutes
     *
     * @return void
     */
    public function add($key, $value, $minutes)
    {
        $validUntil = now()->addMinutes($minutes);

        DB::table(self::TABLE_NAME)->insert([
            'id' => Str::orderedUuid(),
            'key' => $key,
            'valid_until' => $validUntil,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Add a new item into storage indefinitely.
     *
     * @param string $key
     *
     * @return void
     */
    public function forever($key, $value)
    {
        DB::table(self::TABLE_NAME)->insert([
            'id' => Str::orderedUuid(),
            'key' => $key,
            'valid_until' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Get an item from storage.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        $blackListedToken = DB::table(self::TABLE_NAME)->where('key', $key)->first();
        if ($blackListedToken) {
            return collect($blackListedToken)->toArray();
        }
        return null;
    }

    /**
     * Remove an item from storage.
     *
     * @param string $key
     *
     * @return bool
     */
    public function destroy($key)
    {
        return DB::table(self::TABLE_NAME)->where('key', $key)->delete();
    }

    /**
     * Remove all items from storage.
     *
     * @return void
     */
    public function flush()
    {
        DB::table(self::TABLE_NAME)->truncate();
    }

    /**
     * Remove all expired items from storage.
     *
     * @return void
     */
    public function removeExpired()
    {
        DB::table(self::TABLE_NAME)->where('valid_until', '<', now())->delete();
    }
}
