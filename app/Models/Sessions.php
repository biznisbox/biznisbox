<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Http\Request;
use foroco\BrowserDetection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class Sessions extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'sessions';

    protected $fillable = [
        'user_id',
        'token',
        'ip',
        'user_agent',
        'device_type',
        'os',
        'os_family',
        'browser',
        'location',
        'country',
        'country_code',
        'region',
        'latitude',
        'longitude',
        'client_data',
        'ip_data',
        'fingerprint',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected $hidden = ['token', 'user_agent', 'client_data', 'ip_data', 'fingerprint'];

    public function generateTags(): array
    {
        return ['Sessions'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    /*
     * Save session
     * @param string $user_id  User ID
     * @param string $token  JWT generated token
     * @param string $expires_at  Token expires at (datetime)
     * @return void
     */
    public function saveSession($user, $token, $expires_at)
    {
        $request = Request::capture();
        $browser = new BrowserDetection();
        $browser = $browser->getAll($request->userAgent());
        $ip_data = $this->getIpLocation($request->ip());
        $session_data = [
            'user_id' => $user->id,
            'token' => $token,
            'expires_at' => $expires_at,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_type' => $browser['device_type'],
            'os' => $browser['os_title'],
            'os_family' => $browser['os_family'],
            'browser' => Str::lower($browser['browser_title']),
            'client_data' => json_encode($browser),
            'ip_data' => json_encode($ip_data),
            'location' => $ip_data['geoplugin_city'] ?? null,
            'country' => $ip_data['geoplugin_countryName'] ?? null,
            'country_code' => $ip_data['geoplugin_countryCode'] ?? null,
            'region' => $ip_data['geoplugin_region'] ?? null,
            'latitude' => $ip_data['geoplugin_latitude'] ?? null,
            'longitude' => $ip_data['geoplugin_longitude'] ?? null,
            'fingerprint' => $this->generateFingerprint($browser['device_type'], $request->ip(), $request->userAgent(), $user->id),
        ];
        $this->create($session_data);
    }

    /*
     * Mark session as expired (logout)
     * @param string $user_id current user id
     * @param string $token session token
     * @return void
     */

    public function revokeSession($user_id, $token)
    {
        $session = $this->where('user_id', $user_id)
            ->where('token', $token)
            ->first();
        if ($session) {
            $session->is_active = false;
            $session->expires_at = null;
            $session->save();
            return true;
        }
        return false;
    }

    /**
     * Get IP location data
     * @param string $ip  IP address
     * @return array|null IP location data
     *
     * @see https://www.geoplugin.com/webservices/json
     */

    public function getIpLocation($ip)
    {
        if ($ip == '::1') {
            $ip = '';
        } // localhost

        $request = Http::get('http://www.geoplugin.net/json.gp?ip=' . $ip);
        if ($request->successful()) {
            return $request->json();
        }
        return null;
    }

    /**
     * Generate session fingerprint
     * @param string $device  Device type
     * @param string $ip  IP address
     * @param string $user_agent  User agent
     * @param string $user_id  User ID
     * @return string  Session fingerprint (sha1)
     */
    public function generateFingerprint($device, $ip, $user_agent, $user_id)
    {
        return sha1($device . $ip . $user_agent . $user_id);
    }
}
