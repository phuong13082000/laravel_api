<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'addressLine' => 'string',
            'city' => 'string',
            'state' => 'string',
            'pinCode' => 'string',
            'country' => 'string',
            'mobile' => 'string',
        ]);

        $user->addresses()->create([
            'addressLine' => $request['addressLine'],
            'city' => $request['city'],
            'state' => $request['state'],
            'pinCode' => $request['pinCode'],
            'country' => $request['country'],
            'mobile' => $request['mobile'],
        ]);

        return $this->responseSuccess([]);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();

        $request->validate([
            'addressLine' => 'string',
            'city' => 'string',
            'state' => 'string',
            'pinCode' => 'string',
            'country' => 'string',
            'mobile' => 'string',
        ]);

        $address = $user->addresses()->where('id', $id)->first();

        if (!$address) {
            return $this->responseError('Address not found');
        }

        $address->update([
            'addressLine' => $request['addressLine'],
            'city' => $request['city'],
            'state' => $request['state'],
            'pinCode' => $request['pinCode'],
            'country' => $request['country'],
            'mobile' => $request['mobile'],
        ]);

        return $this->responseSuccess([]);
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();

        $address = $user->addresses()->where('id', $id)->first();

        if (!$address) {
            return $this->responseError('Address not found');
        }

        $address->status = 0;
        $address->save();

        return $this->responseSuccess([]);
    }
}
