<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{
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

    public function deleteAddress(Request $request, $id)
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
