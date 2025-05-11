<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->responseError('Invalid credentials');
        }

        if ($user->status != "active") {
            return $this->responseError('Your account is not active. Contact the administrator');
        }

        $token = generateToken($user);

        $user->load('addresses')->makeHidden('created_at', 'updated_at', 'email_verified_at', 'status', 'role');

        foreach ($user->addresses as $address) {
            $address->makeHidden('user_id', 'created_at', 'updated_at', 'status');
        }

        return $this->responseSuccess([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $token = generateToken($user);

        $user->load('addresses')->makeHidden('created_at', 'updated_at', 'email_verified_at', 'status', 'role');

        foreach ($user->addresses as $address) {
            $address->makeHidden('user_id', 'created_at', 'updated_at', 'status');
        }

        return $this->responseSuccess([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();

        $user->load('addresses')->makeHidden('created_at', 'updated_at', 'email_verified_at', 'status', 'role');

        foreach ($user->addresses as $address) {
            $address->makeHidden('user_id', 'created_at', 'updated_at', 'status');
        }

        return $this->responseSuccess($user);
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

            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
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
            [
                'token' => bcrypt($token),
                'created_at' => Carbon::now()
            ]
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

    public function createAddress(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'address_line' => 'string',
            'city' => 'string',
            'state' => 'string',
            'pincode' => 'string',
            'country' => 'string',
            'mobile' => 'string',
        ]);

        $user->addresses()->create([
            'address_line' => $request['address_line'],
            'city' => $request['city'],
            'state' => $request['state'],
            'pincode' => $request['pincode'],
            'country' => $request['country'],
            'mobile' => $request['mobile'],
        ]);

        return $this->responseSuccess([]);
    }

    public function updateAddress(Request $request, $id)
    {
        $user = $request->user();

        $request->validate([
            'address_line' => 'string',
            'city' => 'string',
            'state' => 'string',
            'pincode' => 'string',
            'country' => 'string',
            'mobile' => 'string',
        ]);

        $address = $user->addresses()->where('id', $id)->first();

        if (!$address) {
            return $this->responseError('Address not found');
        }

        $address->update([
            'address_line' => $request['address_line'],
            'city' => $request['city'],
            'state' => $request['state'],
            'pincode' => $request['pincode'],
            'country' => $request['country'],
            'mobile' => $request['mobile'],
        ]);

        return $this->responseSuccess([]);
    }
}
