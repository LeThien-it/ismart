<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    // AdminController
    Route::get('/', 'AdminController@login')->name('admin.login');
    Route::post('/', 'AdminController@postLoginAdmin')->name('admin.post-login');
    Route::get('/logout', 'AdminController@logout')->name('admin.logout');

    //DashboardController
    Route::get('/dashboard', 'AdminDashboardController@show')->name('dashboard.show')->middleware('auth');

    //UserController
    Route::prefix('user')->group(function () {
        Route::get('/list', 'AdminUserController@list')->name('user.list')->middleware('can:list_user');
        Route::get('/add', 'AdminUserController@add')->name('user.add')->middleware('can:add_user');
        Route::post('/store', 'AdminUserController@store');
        Route::get('/delete/{id}', 'AdminUserController@delete')->name('user.delete')->middleware('can:delete_user');
        Route::get('/edit/{id}', 'AdminUserController@edit')->name('user.edit')->middleware('can:edit_user');
        Route::post('/update/{id}', 'AdminUserController@update')->name('user.update');
        Route::get('/changePassword/{id}', 'AdminUserController@changePassword')->name('user.password')->middleware('can:edit_user');
        Route::post('/updatePassword/{id}', 'AdminUserController@updatePassword')->name('user.updatePassword');
        Route::get('/action', 'AdminUserController@action')->name('user.action')->middleware('can:delete_user');
    });

    //PostController
    Route::group(['prefix' => 'post', 'middleware' => 'auth'],function () {
        Route::get('/list', 'AdminPostController@list')->name('post.list')->middleware('can:list_post');
        Route::get('/add', 'AdminPostController@add')->name('post.add')->middleware('can:add_post');
        Route::post('/store', 'AdminPostController@store')->name('post.store');
        Route::get('/edit/{id}', 'AdminPostController@edit')->name('post.edit')->middleware('can:edit_post');
        Route::post('/update/{id}', 'AdminPostController@update')->name('post.update');
        Route::get('/delete/{id}', 'AdminPostController@delete')->name('post.delete')->middleware('can:delete_post');
        Route::get('/action', 'AdminPostController@action')->name('post.action')->middleware('can:delete_post');
        Route::get('/convert-status/{id}', 'AdminPostController@convertStatus')->name('post.status')->middleware('can:edit_post');

        Route::prefix('/cat')->group(function () {
            Route::get('/list', 'AdminCategoryPostController@list')->name('post.cat.list')->middleware('can:list_post');

            Route::post('/add', 'AdminCategoryPostController@add')->name('post.cat.add');

            Route::get('/edit/{id}', 'AdminCategoryPostController@edit')->name('post.cat.edit')->middleware('can:edit_post');

            Route::post('/update/{id}', 'AdminCategoryPostController@update')->name('post.cat.update');

            Route::get('/delete/{id}', 'AdminCategoryPostController@delete')->name('post.cat.delete')->middleware('can:delete_post');

            Route::get('/action', 'AdminCategoryPostController@action')->name('post.cat.action')->middleware('can:delete_post');
        });
    });

    //Attribute
    Route::group(['prefix' => 'attribute', 'middleware' => 'auth'], function () {
        Route::get('/list', 'AdminAttributeController@list')->name('attribute.list')->middleware('can:list_attribute');

        Route::post('/add', 'AdminAttributeController@add')->name('attribute.add');

        Route::get('/edit/{id}', 'AdminAttributeController@edit')->name('attribute.edit')->middleware('can:edit_attribute');

        Route::post('/update/{id}', 'AdminAttributeController@update')->name('attribute.update');

        Route::get('/delete/{id}', 'AdminAttributeController@delete')->name('attribute.delete')->middleware('can:delete_attribute');

        Route::get('/action', 'AdminAttributeController@action')->name('attribute.action')->middleware('can:delete_attribute');

        Route::get(
            '/convert-status/{id}',
            'AdminAttributeController@convertStatus'
        )->name('attribute.status')->middleware('can:edit_attribute');

        //value
        Route::prefix('value')->group(function () {
            Route::get('/list', 'AdminAttributeValueController@list')->name('attribute.value.list')->middleware('can:list_attribute');

            Route::post('/add', 'AdminAttributeValueController@add')->name('attribute.value.add');

            Route::get('/edit/{id}', 'AdminAttributeValueController@edit')->name('attribute.value.edit')->middleware('can:edit_attribute');

            Route::post('/update/{id}', 'AdminAttributeValueController@update')->name('attribute.value.update');

            Route::get('/delete/{id}', 'AdminAttributeValueController@delete')->name('attribute.value.delete')->middleware('can:delete_attribute');

            Route::get('/action', 'AdminAttributeValueController@action')->name('attribute.value.action')->middleware('can:delete_attribute');
        });
    });

    // AdminProductController
    include('route-product.php');

    //PageController
    Route::group(['prefix' => 'page', 'middleware' => 'auth'],function () {
        Route::get('/list', 'AdminPageController@list')->name('page.list')->middleware('can:list_page');
        Route::get('/add', 'AdminPageController@add')->name('page.add')->middleware('can:add_page');
        Route::post('/store', 'AdminPageController@store')->name('page.store');
        Route::get('/edit/{id}', 'AdminPageController@edit')->name('page.edit')->middleware('can:edit_page');
        Route::post('/update/{id}', 'AdminPageController@update')->name('page.update');
        Route::get('/delete/{id}', 'AdminPageController@delete')->name('page.delete')->middleware('can:delete_page');
        Route::get('/action', 'AdminPageController@action')->name('page.action')->middleware('can:delete_page');
        Route::get('/convert-status/{id}', 'AdminPageController@convertStatus')->name('page.status')->middleware('can:edit_page');
    });

    //SliderController
    Route::group(['prefix' => 'slider', 'middleware' => 'auth'],function () {
        Route::get('/list', 'AdminSliderController@list')->name('slider.list')->middleware('can:list_slider');
        Route::get('/add', 'AdminSliderController@add')->name('slider.add')->middleware('can:add_slider');
        Route::post('/store', 'AdminSliderController@store')->name('slider.store');
        Route::get('/edit/{id}', 'AdminSliderController@edit')->name('slider.edit')->middleware('can:edit_slider');
        Route::post('/update/{id}', 'AdminSliderController@update')->name('slider.update');
        Route::get('/delete/{id}', 'AdminSliderController@delete')->name('slider.delete')->middleware('can:delete_slider');
        Route::get('/action', 'AdminSliderController@action')->name('slider.action')->middleware('can:delete_slider');
        Route::get('/convert-status/{id}', 'AdminSliderController@convertStatus')->name('slider.status')->middleware('can:edit_slider');
    });

    //AdminOrderController
    Route::group(['prefix' => 'order', 'middleware' => 'auth'],function () {
        Route::get('/list', 'AdminOrderController@list')->name('order.list');
        Route::get('/detail/{id}', 'AdminOrderController@detail')->name('order.detail');
        Route::post('/update/{id}', 'AdminOrderController@update')->name('order.update');
        Route::get('/delete/{id}', 'AdminOrderController@delete')->name('order.delete');
        Route::get('/action', 'AdminOrderController@action')->name('order.action');
    });

    //AdminRoleController
    Route::group(['prefix' => 'role', 'middleware' => 'auth'],function () {
        Route::get('/list', 'AdminRoleController@list')->name('role.list')->middleware('can:list_role');
        Route::get('/add', 'AdminRoleController@add')->name('role.add')->middleware('can:add_role');
        Route::post('/store', 'AdminRoleController@store')->name('role.store');
        Route::get('/delete/{id}', 'AdminRoleController@delete')->name('role.delete')->middleware('can:delete_role');
        Route::get('/edit/{id}', 'AdminRoleController@edit')->name('role.edit')->middleware('can:edit_role');
        Route::post('/update/{id}', 'AdminRoleController@update')->name('role.update');
        Route::get('/action', 'AdminRoleController@action')->name('role.action')->middleware('can:delete_role');
    });

    //AdminCustomerController
    Route::group(['prefix' => 'customer', 'middleware' => 'auth'],function () {
        Route::get('/list', 'AdminCustomerController@list')->name('customer.list')->middleware('can:list_customer');
        Route::get('/delete/{id}', 'AdminCustomerController@delete')->name('customer.delete')->middleware('can:delete_customer');
        Route::get('/action', 'AdminCustomerController@action')->name('customer.action')->middleware('can:delete_customer');
    });

    //AdminRatingController
    Route::group(['prefix' => 'rating', 'middleware' => 'auth'],function () {
        Route::get('/list', 'AdminRatingController@list')->name('rating.list')->middleware('can:list_rating');
        Route::get('/delete/{id}', 'AdminRatingController@delete')->name('rating.delete')->middleware('can:delete_rating');
        Route::get('/action', 'AdminRatingController@action')->name('rating.action')->middleware('can:delete_rating');
        Route::get('/convert-status/{id}', 'AdminRatingController@convertStatus')->name('rating.status')->middleware('can:edit_rating');
    });
});
