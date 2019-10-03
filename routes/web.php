<?php

Route::get('/', 'PagesController@root')->name('root')->middleware('verified');


Auth::routes(['verify' => true]); //邮箱验证


Route::group(['middleware' => ['auth', 'verified']], function(){

    Route::get('user_address', 'UserAddressController@index')->name('user_address.index');
    Route::get('user_address/create', 'UserAddressController@create')->name('user_address.create');
});


