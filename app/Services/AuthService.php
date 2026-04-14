<?php

namespace App\Services;

use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $userRepo;

    public function __construct(AuthRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    // Register
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['role'] = $data['role'] ?? 'landlord';

        $user = $this->userRepo->create($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    // Login
    public function login(array $data)
    {
        if (!Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ])) {
            return null;
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    // Logout
    public function logout($user)
    {
        $user->tokens()->delete();
    }
}
