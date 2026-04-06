<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_returns_bearer_token_and_user_json(): void
    {
        User::factory()->create([
            'email' => 'api@test.com',
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'api@test.com',
            'password' => 'password',
        ]);

        $response->assertOk()
            ->assertJsonPath('codigo', 200)
            ->assertJsonPath('dados.token_type', 'Bearer')
            ->assertJsonStructure([
                'dados' => ['token', 'token_type', 'user' => ['id', 'name', 'email']],
            ]);
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'api@test.com',
        ]);

        $this->postJson('/api/auth/login', [
            'email' => 'api@test.com',
            'password' => 'wrong-password',
        ])->assertUnprocessable();
    }

    public function test_disciplinas_listar_requires_authentication(): void
    {
        $this->getJson('/api/disciplinas/listar')->assertUnauthorized();
    }

    public function test_disciplinas_listar_with_bearer_token_succeeds(): void
    {
        User::factory()->create(['email' => 'u@test.com']);

        $token = $this->postJson('/api/auth/login', [
            'email' => 'u@test.com',
            'password' => 'password',
        ])->json('dados.token');

        $this->getJson('/api/disciplinas/listar', [
            'Authorization' => 'Bearer '.$token,
        ])->assertOk();
    }
}
