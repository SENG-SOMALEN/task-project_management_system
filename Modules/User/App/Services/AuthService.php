<?php

namespace Modules\User\App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\App\Interfaces\UserRepositoryInterface;

class AuthService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        $data['role'] = 'TeamMember';
        $data['status'] = true;

        return $this->userRepository->create($data);
    }

    public function login(string $email, string $password)
    {
        $user = $this->userRepository->findByEmail($email);

        if (
            !$user ||
            !Hash::check($password, $user->password)
        ) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!$user->status) {
            throw ValidationException::withMessages([
                'email' => ['Your account is inactive.'],
            ]);
        }

        $token = $user
            ->createToken('auth_token')
            ->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout($user): bool
    {
        $user->currentAccessToken()?->delete();

        return true;
    }
}