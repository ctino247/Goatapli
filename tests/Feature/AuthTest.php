<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Otp;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_but_not_login_without_verification()
    {
        $response = $this->post('/register', [
            'phone' => '1234567890',
            'email' => 'test@example.com',
            'username' => 'testuser',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com', 'is_verified' => false]);

        $loginResponse = $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'password123',
        ]);

        $loginResponse->assertRedirect(route('verify.show', ['email' => 'test@example.com']));
        $this->assertFalse(auth()->check());
    }

    public function test_user_can_verify_otp_and_login()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'username' => 'testuser',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'referral_code' => 'TESTCODE',
            'is_verified' => false,
        ]);

        $otpCode = '123456';
        Otp::create([
            'user_id' => $user->id,
            'code' => \Illuminate\Support\Facades\Hash::make($otpCode),
            'expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->post('/verify', [
            'email' => 'test@example.com',
            'otp' => $otpCode,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertTrue($user->fresh()->is_verified);
        $this->assertTrue(auth()->check());
    }
}
