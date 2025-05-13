<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private function generateToken(User $user): string
    {
        $token = $user->createToken('user-token');
        $accessToken = $token->accessToken;
        $accessToken['expires_at'] = now()->addDays(7);
        $accessToken->save();

        return $token->plainTextToken;
    }

    public function login(LoginRequest $request)
    {
        $user = User::with('addresses')->where('email', $request['email'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return $this->responseError('Invalid credentials');
        }

        if ($user->status != "active") {
            return $this->responseError('Your account is not active. Contact the administrator');
        }

        $token = $this->generateToken($user);

        foreach ($user->addresses as $address) {
            $address->makeHidden('user_id', 'created_at', 'updated_at', 'status');
        }

        return $this->responseSuccess([
            'id' => $user->id,
            'token' => $token,
            'name' => $user->name,
            'email' => $user->email,
            'addresses' => $user->addresses,
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $token = $this->generateToken($user);

        $user->load('addresses');

        foreach ($user->addresses as $address) {
            $address->makeHidden('user_id', 'created_at', 'updated_at', 'status');
        }

        return $this->responseSuccess([
            'id' => $user->id,
            'token' => $token,
            'name' => $user->name,
            'email' => $user->email,
            'addresses' => $user->addresses,
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user()->load('addresses');

        foreach ($user->addresses as $address) {
            $address->makeHidden('user_id', 'created_at', 'updated_at', 'status');
        }

        return $this->responseSuccess([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'addresses' => $user->addresses,
            'role' => $user->role,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->responseSuccess([]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),

            fn($user, $password) => $user->forceFill(['password' => bcrypt($password)])->save()
        );

        return $this->responseSuccess([], message: __($status));
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request['email'])->first();

        if (!$user) {
            return $this->responseError('Email not found');
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => bcrypt($token), 'created_at' => Carbon::now()],
        );

        return $this->responseSuccess(['reset_token' => $token]);
    }

    public function updateUser(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'email' => 'email',
            'name' => 'string',
            'password' => 'min:6|confirmed',
        ]);

        $user->update($request->only('email', 'name', 'password'));

        return $this->responseSuccess($user);
    }
}
