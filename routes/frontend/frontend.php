<?php
Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/tin-tuc/{slug?}','PostController@show')->name('frontend.post.show');
    Route::get('/tin-tuc/{slug}/{slugPost}','PostController@detail')->name('frontend.post.detail');
    Route::get('/Trang-{slug}','PageController@detail')->name('frontend.page.detail');
    
    //cart
    Route::prefix('/cart')->group(function () {
        Route::get('/', 'ShoppingCartController@show')->name('cart.show');
        Route::get('/add/{id}', 'ShoppingCartController@add')->name('cart.add');
        Route::get('/update', 'ShoppingCartController@update')->name('cart.update');
        Route::get('/delete/{id}', 'ShoppingCartController@delete')->name('cart.delete');
        Route::get('/destroy', 'ShoppingCartController@destroy')->name('cart.destroy');
        
        Route::get('/pay', 'ShoppingCartController@pay')->name('cart.pay');
        Route::post('/pay', 'ShoppingCartController@postPay')->name('cart.post.pay');
    });
    Route::post('/ajax/image', 'AjaxController@ajaxImage')->name('frontend.ajaxImage');

    //products
    Route::get('/tim-kiem', 'ProductController@search')->name('frontend.product.search');
    Route::get('/suggestions', 'ProductController@suggestions')->name('frontend.product.suggestions');
    Route::get('/{slug}', 'ProductController@category')->name('frontend.product.category');
    Route::get('/{slug}/{productSlug}', 'ProductController@detail')->name('frontend.product.detail');
    Route::post('/ajax/review/{id}','RatingController@addRating')->name('frontend.rating.add');
    Route::get('/', 'HomeController@index')->name('frontend.home.index');

});
