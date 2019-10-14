<?php

//Route::get('/', 'PagesController@root')->name('root')->middleware('verified');

//Route::get('alipay', function() {
//    return app('alipay')->web([
//        'out_trade_no' => time(),
//        'total_amount' => '1',
//        'subject' => 'test subject - 测试',
//    ]);
//});

Route::redirect('/', '/products')->name('root');
Route::get('products', 'ProductsController@index')->name('products.index');

Auth::routes(['verify' => true]); //邮箱验证

Route::group(['middleware' => ['auth', 'verified']], function(){

    Route::get('user_address', 'UserAddressController@index')->name('user_address.index');
    Route::get('user_address/create', 'UserAddressController@create')->name('user_address.create');
    Route::post('user_address', 'UserAddressController@store')->name('user_address.store');
    Route::get('user_address/{user_address}', 'UserAddressController@edit')->name('user_address.edit');
    Route::put('user_address/{user_address}', 'UserAddressController@update')->name('user_address.update');
    Route::delete('user_address/{user_address}', 'UserAddressController@destroy')->name('user_address.destroy');

    Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
    Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');

    Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');

    Route::post('cart', 'CartController@add')->name('cart.add');
    Route::get('cart', 'CartController@index')->name('cart.index');
    Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');

    Route::post('orders', 'OrdersController@store')->name('orders.store');
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
    Route::post('orders/{order}/received', 'OrdersController@received')->name('orders.received');

    // 评价
    Route::get('orders/{order}/review', 'OrdersController@review')->name('orders.review.show');
    Route::post('orders/{order}/review', 'OrdersController@sendReview')->name('orders.review.store');

    // 申请退款
    Route::post('orders/{order}/apply_refund', 'OrdersController@applyRefund')->name('orders.apply_refund');
    // 退款回调路由
    Route::post('payment/wechat/refund_notify', 'PaymentController@wechatRefundNotify')->name('payment.wechat.refund_notify');

    Route::get('payment/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');
    Route::get('payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');
    Route::get('payment/{order}/wechat', 'PaymentController@payByWechat')->name('payment.wechat');

    Route::get('coupon_codes/{code}', 'CouponCodesController@show')->name('coupon_codes.show');

});

Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');
Route::post('payment/wechat/notify', 'PaymentController@wechatNotify')->name('payment.wechat.notify');

// 避免和路由products/favorites冲突，此路由要后置
Route::get('products/{product}', 'ProductsController@show')->name('products.show');




