<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;


class AuthenticationTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    public function testUserCanLoginWithValidCredentials()
    {
        $user = User::where('email', 'user@gmail.com')->first();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    public function testUserCannotLoginWithInvalidCredentials()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'invalid_password',
        ]);

        $response->assertStatus(400);
    }
}
