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
    public function userLogin(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'otp' => 'nullable',
        ]);

        $login = $this->authService->Login($data);
        if (!$login) {
            return apiResponse(null, __('responses.invalid_credentials'), 401);
        }
        return apiResponse($login, $login['message'] ?? __('responses.login_successful'));
    }

    /**
     * Logout
     *
     * @return array $user User
     * @authenticated
     */
    public function userLogout()
    {
        $this->authService->Logout();
        return apiResponse(null, __('responses.logout_successful'));
    }

    /**
     * Refresh token
     *
     * @return array $token Token
     * @authenticated
     */
    public function tokenRefresh()
    {
        $token = $this->authService->Refresh();
        return apiResponse($token, __('responses.token_refreshed'));
    }

    /**
     * Me
     *
     * @return array $user User
     * @authenticated
     */
    public function meData()
    {
        $user = $this->authService->Me();
        if (!$user) {
            return apiResponse(null, __('responses.unauthenticated'), 401);
        }
        return apiResponse($user, __('responses.data_retrieved_successfully'));
    }
}
