<?php
Route::group(['prefix' => 'product', 'middleware' => 'auth'],function () {
    Route::get('/list', 'AdminProductController@list')->name('product.list');
    Route::get('/add', 'AdminProductController@add')->name('product.add');
    Route::post('/store', 'AdminProductController@store')->name('product.store');
    Route::get('/edit/{id}', 'AdminProductController@edit')->name('product.edit');
    Route::post('/update/{id}', 'AdminProductController@update')->name('product.update');
    Route::get('/delete/{id}', 'AdminProductController@delete')->name('product.delete');
    Route::get('/action', 'AdminProductController@action')->name('product.action');
    Route::get('/convert-status/{id}', 'AdminProductController@convertStatus')->name('product.status');
    Route::get('/feature/{id}', 'AdminProductController@feature')->name('product.feature');

    Route::prefix('/cat')->group(function () {
        Route::get('/list', 'AdminCategoryProductController@list')->name('product.cat.list')->middleware('can:list_product');
        Route::post('/add', 'AdminCategoryProductController@add')->name('product.cat.add');
        Route::get('/edit/{id}', 'AdminCategoryProductController@edit')->name('product.cat.edit')->middleware('can:edit_product');
        Route::post('/update/{id}', 'AdminCategoryProductController@update')->name('product.cat.update');
        Route::get('/delete/{id}', 'AdminCategoryProductController@delete')->name('product.cat.delete')->middleware('can:delete_product');
        Route::get('/action', 'AdminCategoryProductController@action')->name('product.cat.action')->middleware('can:delete_product');
    });
    
    Route::prefix('/variant')->group(function () {
        Route::get('/list', 'AdminProductVariantController@list')->name('product.variant.list')->middleware('can:list_product');
        Route::get('/add', 'AdminProductVariantController@add')->name('product.variant.add')->middleware('can:add_product');
        Route::post('/store', 'AdminProductVariantController@store')->name('product.variant.store');
        Route::get('/edit/{id}', 'AdminProductVariantController@edit')->name('product.variant.edit')->middleware('can:edit_product');
        Route::post('/update/{id}', 'AdminProductVariantController@update')->name('product.variant.update');
        Route::get('/delete/{id}', 'AdminProductVariantController@delete')->name('product.variant.delete')->middleware('can:delete_product');
        Route::get('/action', 'AdminProductVariantController@action')->name('product.variant.action')->middleware('can:delete_product');
    });
    Route::prefix('/image')->group(function () {
        Route::get('/list/{id}', 'AdminProductImageController@list')->name('product.image.list')->middleware('can:list_product');
        Route::post('/add/{id}', 'AdminProductImageController@add')->name('product.image.add');
        Route::get('/delete/{id}', 'AdminProductImageController@delete')->name('product.image.delete')->middleware('can:delete_product');
        Route::get('/action/{id}', 'AdminProductImageController@action')->name('product.image.action')->middleware('can:delete_product');
    });
});
