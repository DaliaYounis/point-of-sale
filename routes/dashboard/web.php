<?php

Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {
    Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
        Route::get('/index', 'DashboardController@index')->name('index');
        Route::resource('/users', 'UserController')->except(['show']);
        Route::resource('/categories', 'CategoryController')->except(['show']);
        Route::resource('/products', 'ProductController')->except(['show']);
        Route::resource('/clients', 'ClientController')->except(['show']);
        Route::get('/orders/create/{client_id}','OrderController@create')->name('orders.create');
        Route::get('/orders','OrderController@index')->name('orders.index');
        Route::get('/orders/edit/{order}/{client}','OrderController@edit')->name('orders.edit');
        Route::put('/orders/update/{order}/{client}','OrderController@update')->name('orders.update');
        Route::get('/orders/{order}/products','OrderController@products')->name('orders.products');
        Route::post('/orders/store/{client}','OrderController@store')->name('orders.store');
        Route::delete('/orders/{order}','OrderController@destroy')->name('orders.destroy');
    });

});






