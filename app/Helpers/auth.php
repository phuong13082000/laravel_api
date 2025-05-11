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
