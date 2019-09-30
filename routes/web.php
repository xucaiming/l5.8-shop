<?php

Route::get('/', 'PagesController@root')->name('root')->middleware('verified');


Auth::routes(['verify' => true]); //邮箱验证


