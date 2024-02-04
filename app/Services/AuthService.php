<?php
namespace App\Services;

use App\Models\User;
use App\Models\Sessions;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\Auth\PasswordReset;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    /**
     * Login
     * @param string $email user email address
     * @param string $password user password in plain text
     * @return void
     */
    public function Login($email, $password)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            if (Hash::check($password, $user->password)) {
                $token = $this->generateToken($user);
                $user->updateLastLogin();
                activity_log($user->id, 'login', $user->id, 'App\Services\AuthService', 'Login');
                return $token;
            }
        }
        return false;
    }

    /**
     * Generate token
     * @param User $user User model
     * @return void
     */
    private function generateToken($user)
    {
        $session = new Sessions();
        $employee = \App\Models\Employee::where('user_id', $user->id)->first();
        $key = config('app.jwt_key');
        $hash_algo = config('app.jwt_algo');
        $login_token = Str::random(60);
        $expires_at = now()->addHour(2)->unix();
        $payload = [
            'iss' => 'BiznisBox',
            'aud' => 'BiznisBox',
            'iat' => now()->unix(),
            'jti' => $login_token,
            'nbf' => now()->unix(),
            'exp' => $expires_at,
            'data' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $user->role,
                'lang' => $user->language,
                'picture' => $user->picture,
                'initials' => $user->getInitials(),
                'employee_id' => $employee ? $employee->id : null,
                'permissions' => format_permissions($user->getPermissionsViaRoles()),
            ],
        ];
        $session->saveSession($user, $login_token, $expires_at);
        $jwt = JWT::encode($payload, $key, $hash_algo);
        return $jwt;
    }

    /**
     * Logout
     * @param string $token JWT token
     * @return void
     */
    public function Logout($token)
    {
        $key = config('app.jwt_key');
        $hash_algo = config('app.jwt_algo');
        $decoded = JWT::decode($token, new Key($key, $hash_algo));
        if ($decoded) {
            $session = new Sessions();
            $session->revokeSession($decoded->data->id, $decoded->jti);
            return true;
        }
        return false;
    }

    /**
     * Validate token if is token expired mark session as expired
     * @param string $token JWT token
     * @return void
     */
    public function validateToken($token)
    {
        $key = config('app.jwt_key');
        $hash_algo = config('app.jwt_algo');
        try {
            $decoded = JWT::decode($token, new Key($key, $hash_algo));
            if ($decoded) {
                if ($decoded->exp > now()->unix()) {
                    return true;
                }
                $session = new Sessions();
                $session->revokeSession($decoded->data->id, $decoded->jti);
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Decode token
     * @param string $token JWT token
     * @return object|bool|null
     */
    public function decodeToken($token)
    {
        $key = config('app.jwt_key');
        $hash_algo = config('app.jwt_algo');
        try {
            $decoded = JWT::decode($token, new Key($key, $hash_algo));
            return $decoded;
        } catch (\Exception $e) {
            return null;
        }
        return false;
    }

    /**
     * Reset user password
     * @param string $email User email
     * @return void
     */
    public function selfResetPassword($email)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            $token = Str::random(60);
            $db = DB::table('password_resets')
                ->where('email', $email)
                ->insert([
                    'id' => Str::uuid(),
                    'user_id' => $user->id,
                    'token' => $token,
                    'valid_until' => now()->addHours(2),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            if ($db) {
                Mail::to($user->email)->send(new PasswordReset($token, $user));
                return true;
            }
        }
        return false;
    }

    /**
     * Set new password
     * @param string $email User email
     * @param string $password New password in plain text
     * @param string $token Password reset token from email
     * @param string $password_confirmation  Password confirmation
     * @return void Return true if password is changed or false if not
     */

    public function setNewPassword($email, $password, $token, $password_confirmation)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            $db = DB::table('password_resets')
                ->where('user_id', $user->id)
                ->where('token', $token)
                ->first();
            if ($db) {
                if ($db->valid_until > now()) {
                    if ($password == $password_confirmation) {
                        $user->password = Hash::make($password);
                        $user->save();
                        DB::table('password_resets')
                            ->where('user_id', $user->id)
                            ->where('token', $token)
                            ->delete();
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
