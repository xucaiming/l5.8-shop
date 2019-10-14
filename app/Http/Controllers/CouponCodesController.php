<?php

namespace App\Http\Controllers;

use App\Models\CouponCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exceptions\CouponCodeUnavailableException;

class CouponCodesController extends Controller
{

    public function show($code)
    {

        // 判断优惠券是否存在
        if(!$record = CouponCode::where('code', $code)->first()){
//            abort(404);
            throw new CouponCodeUnavailableException('优惠券不存在');
        }

        $record->checkAvailable();

        return $record;
    }
}
