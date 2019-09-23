<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UserTest.
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration.
     *
     * @return void
     */
    public function testUserRegistration(): void
    {
        $response = $this->json('POST', '/api/v1/register', [
            'name' => 'Test name',
            'email' => 'test@gmail.com',
            'password' => '123123',
            'password_confirmation' => '123123'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => 'Test name',
                'email' => 'test@gmail.com',
                'id' => 1
            ]);
    }

    /**
     * Test that jwt token works properly.
     *
     * @return void
     */
    public function testUserBearerToken(): void
    {
        User::create([
            'name' => 'Test name',
            'email' => 'test@gmail.com',
            'password' => Hash::make('123123')
        ]);

        $response = $this->json('POST', '/api/v1/login', [
            'email' => 'test@gmail.com',
            'password' => '123123',
        ]);

        $response->assertStatus(200);

        $userInfoResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $response->getOriginalContent()['access_token']
        ])->json('GET', '/api/v1/me');

        $userInfoResponse->assertJson([
            'name' => 'Test name',
            'email' => 'test@gmail.com',
            'id' => 1
        ]);
    }
}
