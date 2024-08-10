<?php

namespace App\Services;

use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PragmaRX\Google2FA\Google2FA;

class AuthService
{
    public function Login($data)
    {
        $token = auth()->attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if (!$token) {
            return null;
        }

        $user = auth()->user();

        if (!$user->active) {
            return [
                'message' => __('responses.disabled_account'),
                'active' => false,
            ];
        }

        if ($user && $user->two_factor_auth && !$data['otp']) {
            return [
                'message' => __('responses.two_factor_auth_required'),
                'two_factor_auth' => true,
            ];
        }

        $token_data = auth()->payload();

        if ($user && $user->two_factor_auth && $data['otp']) {
            $valid = $this->validateOtp($data);
            if ($valid !== true) {
                return $valid;
            }
        }

        $this->saveSession($token_data);

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>
                now()
                    ->addSeconds(auth()->factory()->getTTL() * 60)
                    ->toDateTimeString() . ' UTC',
        ];
    }

    public function Logout()
    {
        $token_data = auth()->payload();
        Session::revokeSession($token_data['sub'], $token_data['jti']);
        Auth::logout();
    }

    public function Refresh()
    {
        $token = auth()->refresh();
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>
                now()
                    ->addSeconds(auth()->factory()->getTTL() * 60)
                    ->toDateTimeString() . ' UTC',
        ];
    }

    public function saveSession($data)
    {
        Session::saveSession($data['sub'], $data['jti'], $data['exp']);

        User::where('id', $data['sub'])->update([
            'last_login_at' => now(),
        ]);
    }

    public function validateOtp($data)
    {
        $user_id = auth()->payload()['sub'];

        $secret = DB::table('2fa')
            ->where(['user_id' => $user_id, 'enabled' => true])
            ->first()->secret;

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($secret, $data['otp'], 2);

        if (!$valid) {
            return [
                'message' => __('responses.invalid_2fa_code'),
                'otp' => false,
            ];
        }

        return true;
    }

    public function Me()
    {
        return auth()->user();
    }
}
