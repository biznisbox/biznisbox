<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

/**
 * @group Auth
 *
 * APIs for managing authentication
 */
class AuthController extends Controller
{
    private $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login
     *
     * @param  object  $request data from the form (email, password, otp)
     * @return array $user User
     */
    public function Login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'otp' => 'nullable',
        ]);

        $login = $this->authService->Login($data);
        if (!$login) {
            return api_response(null, __('responses.invalid_credentials'), 401);
        }
        return api_response($login, $login['message'] ?? __('responses.login_successful'));
    }

    /**
     * Logout
     *
     * @return array $user User
     * @authenticated
     */
    public function Logout()
    {
        $this->authService->Logout();
        return api_response(null, __('responses.logout_successful'));
    }

    /**
     * Refresh token
     *
     * @return array $token Token
     * @authenticated
     */
    public function Refresh()
    {
        $token = $this->authService->Refresh();
        return api_response($token, __('responses.token_refreshed'));
    }

    /**
     * Me
     *
     * @return array $user User
     * @authenticated
     */
    public function Me()
    {
        $user = $this->authService->Me();
        if (!$user) {
            return api_response(null, __('responses.unauthenticated'), 401);
        }
        return api_response($user, __('responses.data_retrieved_successfully'));
    }
}
