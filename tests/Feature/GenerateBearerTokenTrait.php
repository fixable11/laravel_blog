<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;

/**
 * Trait GenerateBearerTokenTrait.
 */
trait GenerateBearerTokenTrait
{
    /**
     * Generates valid jwt token.
     *
     * @param string $email    Email.
     * @param string $password Password.
     *
     * @return string
     */
    public function generateBearerToken(string $email = 'test@gmail.com', string $password = '123123'): string
    {
        $this->createUser($email, $password);

        return auth()->attempt([
            'email' => $email,
            'password' => $password
        ]);
    }

    /**
     * Creates user.
     *
     * @param string $email    Email.
     * @param string $password Password.
     *
     * @return void
     */
    private function createUser(string $email, string $password): void
    {
        User::create([
            'name' => 'Test name',
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }
}
