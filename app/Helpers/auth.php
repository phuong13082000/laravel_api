<?php

use App\Models\User;

if (!function_exists('generateToken')) {
    function generateToken(User $user): string
    {
        $token = $user->createToken('user-token');
        $accessToken = $token->accessToken;
        $accessToken['expires_at'] = now()->addDays(7);
        $accessToken->save();

        return $token->plainTextToken;
    }
}

if (!function_exists('formatUser')) {
    function formatUser(User $user): User
    {
        $user
            ->load('address')
            ->makeHidden('created_at', 'updated_at');

        foreach ($user->address as $address) {
            $address->makeHidden('user_id', 'created_at', 'updated_at');
        }

        return $user;
    }
}
