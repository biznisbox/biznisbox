<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login
     *
     * @param Request $request
     * @return void
     */
    public function Login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $token = $this->authService->login($email, $password);
        if ($token) {
            return api_response($token, __('response.login.success'));
        }
        return api_response(null, __('response.login.failed'), 400);
    }

    /**
     * Logout
     *
     * @param Request $request
     * @return void
     */
    public function Logout(Request $request)
    {
        $token = $request->bearerToken();
        $logout = $this->authService->logout($token);
        if ($logout) {
            return api_response(null, __('response.logout.success'));
        }
        return api_response(null, __('response.logout.failed'), 401);
    }

    public function selfResetPassword(Request $request)
    {
        $email = $request->input('email');
        $reset = $this->authService->selfResetPassword($email);
        if ($reset) {
            return api_response(null, __('response.reset.success'));
        }
        return api_response(null, __('response.reset.failed'), 400);
    }

    public function setNewPassword(Request $request)
    {
        $token = $request->input('token');
        $email = $request->input('email');
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');
        $reset = $this->authService->setNewPassword($email, $password, $token, $password_confirmation);
        if ($reset) {
            return api_response(null, __('response.reset.success'));
        }
        return api_response(null, __('response.reset.failed'), 400);
    }
}
