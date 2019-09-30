<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    public function index(Request $request)
    {
        return view('user_address.index', [
            'address' => $request->user()->address
        ]);
    }
}
