<?php

namespace App\Services;

use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;

use function Illuminate\Log\log;

class AuthService
{
    public function Login($data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return [
                'message' => __('responses.invalid_credentials'),
            ];
        }

        if (Hash::check($data['password'], $user->password) === false) {
            return [
                'message' => __('responses.invalid_credentials'),
            ];
        }

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

        if ($user && $user->two_factor_auth && $data['otp']) {
            $valid = $this->validateOtp($data, $user->id);
            if ($valid !== true) {
                return $valid;
            }
        }

        $token = $user->createToken('Personal Access Token');

        $this->saveSession($token->token);

        return [
            'access_token' => $token->accessToken,
            'token_type' => 'bearer',
            'expires_in' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
        ];
    }

    public function Logout($token)
    {

       // Session::revokeSession($token_data['sub'], $token_data['jti']);
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
        Session::saveSession($data->user_id, $data->id, $data->expires_at);

        User::where('id', $data->user_id)->update([
            'last_login_at' => now(),
        ]);
    }

    public function validateOtp($data, $user_id)
    {
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
