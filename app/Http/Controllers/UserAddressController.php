<?php

namespace App\Http\Controllers;

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
}
