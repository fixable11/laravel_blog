<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

/**
 * Class RegisterController.
 */
class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterUserRequest $request Request.
     *
     * @return Response
     */
    public function register(RegisterUserRequest $request)
    {
        event(new Registered($user = $this->create($request->all())));

        return response($user->toArray(), 200);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data Registration data.
     *
     * @return User
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
