<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Models\User;
use App\Validacoes\Validacoes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $validacoes = new Validacoes;

        $user = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => $request->validated('password'),
        ]);

        $token = $user->createToken('api')->plainTextToken;

        return response()->json(
            $validacoes->gerarRetornoHttp(201, 'Usuário registrado com sucesso.', [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $this->userPayload($user),
            ])
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validacoes = new Validacoes;

        $user = User::where('email', $request->validated('email'))->first();

        if (! $user || ! Hash::check($request->validated('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        if ($user->hasEnabledTwoFactorAuthentication()) {
            return response()->json(
                $validacoes->gerarRetornoHttp(422, 'Conta com autenticação em duas etapas: use o login pelo site ou desative o 2FA para tokens de API.', []),
                422
            );
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json(
            $validacoes->gerarRetornoHttp(200, 'Login realizado com sucesso.', [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $this->userPayload($user),
            ])
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $validacoes = new Validacoes;

        $request->user()?->currentAccessToken()?->delete();

        return response()->json(
            $validacoes->gerarRetornoHttp(200, 'Sessão encerrada.', [])
        );
    }

    public function user(Request $request): JsonResponse
    {
        $validacoes = new Validacoes;

        return response()->json(
            $validacoes->gerarRetornoHttp(200, '', $this->userPayload($request->user()))
        );
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $validacoes = new Validacoes;

        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_THROTTLED) {
            return response()->json(
                $validacoes->gerarRetornoHttp(429, (string) __($status), []),
                429
            );
        }

        return response()->json(
            $validacoes->gerarRetornoHttp(200, 'Se existir uma conta com este e-mail, enviaremos o link para redefinir a senha.', [])
        );
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $validacoes = new Validacoes;

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(
            $validacoes->gerarRetornoHttp(200, 'Senha redefinida com sucesso. Faça login novamente.', [])
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function userPayload(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at?->toIso8601String(),
        ];
    }
}
