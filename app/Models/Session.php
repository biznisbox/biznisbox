<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Support\Facades\Mail;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;
use App\Mail\User\LoginNotification;

class Session extends Model implements Auditable
{
    use HasFactory, HasUuids;
    use \OwenIt\Auditing\Auditable;

    public static $modelName = 'App\Models\Session';

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
        'fingerprint', // Fingerprint is a hash of the user's browser and device information (used for security)
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'expires_at' => 'datetime',
        ];
    }

    protected $hidden = ['token', 'user_agent', 'client_data', 'ip_data', 'fingerprint'];

    public function generateTags(): array
    {
        return ['Session'];
    }

    protected function getDeviceTypeAttribute($value)
    {
        return Str::lower($value);
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
    public static function saveSession($user_id, $token, $expires_at)
    {
        $request = Request::capture();
        $ip_data = self::getIpLocation($request->getClientIp());
        $client = new Browser();
        $client_data = $client->parse($request->userAgent() ?? '');
        $fingerprint = self::generateFingerprint(null, $request->getClientIp(), $request->userAgent() ?? '', $user_id);
        $session_data = [
            'user_id' => $user_id,
            'token' => $token,
            'expires_at' => $expires_at,
            'ip' => $request->getClientIp(),
            'user_agent' => $request->userAgent(),
            'device_type' => $client_data->deviceType(),
            'os' => $client_data->platformName(),
            'os_family' => $client_data->platformFamily(),
            'browser' => $client_data->browserName(),
            'location' => $ip_data['city'] ?? null,
            'country' => $ip_data['country'] ?? null,
            'country_code' => $ip_data['countryCode'] ?? null,
            'region' => $ip_data['regionName'] ?? null,
            'latitude' => $ip_data['lat'] ?? null,
            'longitude' => $ip_data['lon'] ?? null,
            'fingerprint' => $fingerprint,
        ];

        if (self::isFirstTimeLogin($user_id, $fingerprint, $request)) {
            $user = User::find($user_id);
            self::sendLoginNotification($user, (object) $session_data);
        }

        self::create($session_data);
    }

    /*
     * Check if session is first time login
     * @param string $user_id  User ID
     * @param string $fingerprint  Session fingerprint
     * @return bool
     */
    public static function isFirstTimeLogin($user_id, $fingerprint, $request)
    {
        // If request include Zapier, don't send email
        if ($request->header('User-Agent') == 'Zapier Agent') {
            return false;
        }

        $session = self::where('user_id', $user_id)->where('fingerprint', $fingerprint)->first();
        if ($session) {
            return false;
        }
        return true;
    }

    /*
     * Mark session as expired (logout)
     * @param string $user_id current user id
     * @param string $token session token
     * @return void
     */
    public static function revokeSession($user_id, $token)
    {
        $session = self::where('user_id', $user_id)->where('token', $token)->first();
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
     * @see https://ip-api.com/
     */

    public static function getIpLocation($ip)
    {
        try {
            if ($ip == '::1' || $ip == 'localhost') {
                $ip = ''; // if local IP
            }

            $request = Http::get('http://ip-api.com/json/' . $ip);
            if ($request->successful()) {
                return $request->json(); // return location data
            }
            return null;
        } catch (Exception $ex) {
            // if network is unavailable
            return null;
        }
    }

    /**
     * Generate session fingerprint
     * @param string $device  Device type
     * @param string $ip  IP address
     * @param string $user_agent  User agent
     * @param string $user_id  User ID
     * @return string  Session fingerprint (sha1)
     */
    public static function generateFingerprint($device, $ip, $user_agent, $user_id)
    {
        return sha1($device . $ip . $user_agent . $user_id);
    }

    /**
     * Update session status cron
     * @return void
     */
    public static function updateSessionStatusCron()
    {
        $sessions = self::where('expires_at', '<', now())->get();
        foreach ($sessions as $session) {
            $session->is_active = false;
            $session->expires_at = null;
            $session->save();
        }
    }

    public static function sendLoginNotification($user, $login)
    {
        setEmailConfig();
        Mail::to($user->email, $user->first_name . ' ' . $user->last_name)->send(new LoginNotification($user, $login));
    }
}
