<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    private $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

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

    public function Logout()
    {
        $this->authService->Logout();
        return api_response(null, __('responses.logout_successful'));
    }

    public function Refresh()
    {
        $token = $this->authService->Refresh();
        return api_response($token, __('responses.token_refreshed'));
    }

    public function Me()
    {
        $user = $this->authService->Me();
        return api_response($user, __('responses.data_retrieved_successfully'));
    }
}
