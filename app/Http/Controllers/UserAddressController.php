<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function index(Request $request)
    {
        return view('user_address.index', [
            'addresses' => $request->user()->addresses
        ]);
    }

    public function create()
    {
        return view('user_address.create_and_edit', ['address' => new UserAddress()]);
    }

    public function store(UserAddressRequest $request)
    {
        $request->user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));

        return redirect()->route('user_address.index');
    }

    public function edit(UserAddress $user_address)
    {
        return view('user_address.create_and_edit', ['address' => $user_address]);
    }

    public function update(UserAddress $user_address, UserAddressRequest $request)
    {
        $user_address->update($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone'
        ]));

        return redirect()->route('user_address.index');
    }

    public function destroy(UserAddress $user_address)
    {
        $user_address->delete();
        return redirect()->route('user_address.index');
    }
}
