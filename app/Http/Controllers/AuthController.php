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

    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="Login",
     *      tags={"Auth"},
     *      summary="Login",
     *      description="Login",
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                     ),
     *                     @OA\Property(
     *                          property="otp",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                      "email":"user@test.com",
     *                      "otp":"123456",
     *                      "password":"useruser1"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successfully logged in",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Login successful"),
     *              @OA\Property(property="response_time", type="string", example="1.2ms"),
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="status_code", type="number", example=200),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hcGkvdXNlci9sb2dpbiIsImlhdCI6MTYxNzQwNjYwMiwiZXhwIjoxNjE3NDA2NjQyLCJuYmYiOjE2MTc0MDY2NDIsImp0aSI6Ij" ),
     *                  @OA\Property(property="expires_in", type="date", example="2021-04-06 14:00:42"),
     *                  @OA\Property(property="token_type", type="string", example="Bearer"),
     *              ),
     *          ),
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Login successful"),
     *              @OA\Property(property="response_time", type="string", example="1.2ms"),
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="status_code", type="number", example=200),
     *              @OA\Property(property="data", type="string", example="null"),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
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
     * @OA\Post(
     *      path="/api/auth/logout",
     *      operationId="Logout",
     *      tags={"Auth"},
     *      summary="Logout",
     *      description="Logout",
     *      @OA\Response(
     *          response=200,
     *          description="Successfully logged out",
     *            @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Login successful"),
     *              @OA\Property(property="response_time", type="string", example="1.2ms"),
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="status_code", type="number", example=200),
     *              @OA\Property(property="data", type="string", example="dd"),
     *         ),
     *     ),
     * )
     */
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

    /**
     * @OA\Get(
     *      path="/api/me",
     *      operationId="Me",
     *      tags={"Auth"},
     *      summary="Me",
     *      description="Me",
     *      @OA\Response(
     *          response=200,
     *          description="Successfully data retrieved",
     *            @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Login successful"),
     *              @OA\Property(property="response_time", type="string", example="1.2ms"),
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="status_code", type="number", example=200),
     *              @OA\Property(property="data", type="object",
     *              @OA\Property(property="id", type="string", example="9cbbf943-32b4-412f-89ee-e82e18d01e0f"),
     *              @OA\Property(property="first_name", type="string", example="John"),
     *              @OA\Property(property="last_name", type="string", example="Doe"),
     *              @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *              @OA\Property(property="active", type="boolean", example=true),
     *              @OA\Property(property="picture", type="string", example="9cbbf943-32b4-412f-89ee-e82e18d01e0f.jpg"),
     *              @OA\Property(property="last_login_at", type="date", example="2021-04-06 14:00:42"),
     *              @OA\Property(property="language", type="string", example="en"),
     *              @OA\Property(property="timezone", type="string", example="UTC"),
     *              @OA\Property(property="theme", type="string", example="light"),
     *              @OA\Property(property="two_factor_auth", type="boolean", example=true),
     *              @OA\Property(property="type", type="string", example="user"),
     *              @OA\Property(property="full_name", type="string", example="John Doe"),
     *              @OA\Property(property="avatar_url", type="string", example="http://example.com/avatar.jpg"),
     *              @OA\Property(property="role", type="string", example="super_admin"),
     *              @OA\Property(property="roles", type="array", @OA\Items(type="string", example="super_admin")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *        description="Unauthenticated",
     *       @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        @OA\Property(property="response_time", type="string", example="1.2ms"),
     *       @OA\Property(property="status", type="string", example="error"),
     *      @OA\Property(property="status_code", type="number", example=401),
     *     @OA\Property(property="data", type="string", example="null"),
     *   ),
     * )
     * )
     * )
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
