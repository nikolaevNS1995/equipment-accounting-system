<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Управление авторизацией"
 * )
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @OA\Post(
     *      path="/api/auth/login",
     *      summary="Получение токена",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="email", type="string", example="ivanovi@mail.ry"),
     *              @OA\Property(property="password", type="string", example="Qwerty12345"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Пользователь авторизован",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string"),
     *              @OA\Property(property="token_type", type="string", example="bearer"),
     *              @OA\Property(property="expires_in", type="integer", example=3600),
     *          )
     *      )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @OA\Post(
     *        path="/api/auth/me",
     *        summary="Получение пользователя",
     *        tags={"Auth"},
     *        security={{ "bearerAuth": {} }},
     *        @OA\Response(
     *            response=200,
     *            description="Пользователь получен",
     *            @OA\JsonContent(
     *                @OA\Property(property="id", type="integer" example=1),
     *                @OA\Property(property="name", type="string", example="Иванов Иван"),
     *                @OA\Property(property="email", type="string", example="ivanovi@mail.com"),
     *                @OA\Property(property="email_verified_at", type="date", example="2025-03-05T17:29:05.000000Z"),
     *                @OA\Property(property="created_at", type="date", example="2025-03-05T17:29:05.000000Z"),
     *                @OA\Property(property="updated_at", type="date", example="2025-03-05T17:29:05.000000Z"),
     *                @OA\Property(property="deleted_at", type="date", example="null"),
     *            )
     *        )
     *   )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @OA\Post(
     *       path="/api/auth/refresh",
     *       summary="Обновление токена",
     *       tags={"Auth"},
     *       security={{ "bearerAuth": {} }},
     *       @OA\Response(
     *           response=200,
     *           description="Токен обновлен",
     *           @OA\JsonContent(
     *               @OA\Property(property="access_token", type="string"),
     *               @OA\Property(property="token_type", type="string", example="bearer"),
     *               @OA\Property(property="expires_in", type="integer", example=3600),
     *           )
     *       )
     *  )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
