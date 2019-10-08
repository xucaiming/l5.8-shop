<?php

//Route::get('/', 'PagesController@root')->name('root')->middleware('verified');

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

});

// 避免和路由products/favorites冲突，此路由要后置
Route::get('products/{product}', 'ProductsController@show')->name('products.show');


