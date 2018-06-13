<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get( '/', ['as' => 'site', 'uses' => 'Fronts\IndexController@index'] );

Route::group(['prefix' => 'admin', 'middleware' => ['web']], function () {
    Route::get( 'login', ['as' => 'login', 'uses' => 'Admin\UserController@login'] );
    Route::post( 'login', ['as' => 'login_post', 'uses' => 'Admin\UserController@loginPost'] );
    Route::get( 'logout', ['as' => 'logout', 'uses' => 'Admin\UserController@logOut'] );
    Route::get( 'register', ['as' => 'register', 'uses' => 'Admin\UserController@register'] );
});

// ADMIN
Route::group(['prefix' => 'admin','middleware' => ['authadminRoute'] ], function () {//authadminRoute
    Route::get( '/', ['as' => 'home', 'uses' => 'Admin\DashBoardController@index'] );
    Route::get( 'dashboard', ['as' => 'dashboard', 'uses' => 'Admin\DashBoardController@index'] );

    // **** USER ****
    Route::get( 'user', ['as' => 'user-list', 'uses' => 'Admin\UserController@index'] );
    Route::get( 'user/add', ['as' => 'user-add', 'uses' => 'Admin\UserController@formUser'] );
    Route::post( 'user/add', ['as' => 'user-add-post', 'uses' => 'Admin\UserController@addUser'] );
    Route::get( 'user/edit/{id}', ['as' => 'user-edit', 'uses' => 'Admin\UserController@editUser'] );
    Route::post( 'user/edit/{id}', ['as' => 'user-edit-post', 'uses' => 'Admin\UserController@storeUser'] );
    Route::get( 'user/del/{id}', ['as' => 'user-del', 'uses' => 'Admin\UserController@delUser'] );
    // **** USER ****

    // **** BANNER ****
    Route::get( 'banner', ['as' => 'banner', 'uses' => 'Admin\BannerController@index'] );
    Route::get( 'banner/add', ['as' => 'banner-add', 'uses' => 'Admin\BannerController@addBanner'] );
    Route::post( 'banner/add', ['as' => 'banner-add', 'uses' => 'Admin\BannerController@postBanner'] );
    Route::get( 'banner/edit/{id}', ['as' => 'banner-edit', 'uses' => 'Admin\BannerController@editBanner'] );
    Route::post( 'banner/edit/{id}', ['as' => 'banner-edit', 'uses' => 'Admin\BannerController@storeBanner'] );
    Route::get( 'banner/del/{id}', ['as' => 'banner-del', 'uses' => 'Admin\BannerController@delBanner'] );
    // **** BANNER ****

    // **** CATEGORIES ARTICLE ****
    Route::get( 'article-category', ['as' => 'article-category', 'uses' => 'Admin\CategoryController@articleIndex'] );
    Route::get( 'article-category/add', ['as' => 'article-category-add', 'uses' => 'Admin\CategoryController@articleAddCategory'] );
    Route::post( 'article-category/add', ['as' => 'article-category-add', 'uses' => 'Admin\CategoryController@articlePostCategory'] );
    Route::get( 'article-category/edit/{id}', ['as' => 'article-category-edit', 'uses' => 'Admin\CategoryController@articleEditCategory'] );
    Route::post( 'article-category/edit/{id}', ['as' => 'article-category-edit', 'uses' => 'Admin\CategoryController@articleStoreCategory'] );
    Route::get( 'article-category/del/{id}', ['as' => 'article-category-del', 'uses' => 'Admin\CategoryController@articleDelCategory'] );
    Route::post( 'article-category/change-status', ['as'=>'article-category-status', 'uses'=> 'Admin\CategoryController@articleChangeStatus'] );
    // **** CATEGORIES ARTICLE ****

    // **** CATEGORIES PRODUCT ****
    Route::get( 'product-category', ['as' => 'product-category', 'uses' => 'Admin\CategoryController@productIndex'] );
    Route::get( 'product-category/add', ['as' => 'product-category-add', 'uses' => 'Admin\CategoryController@productAdd'] );
    Route::post( 'product-category/add', ['as' => 'product-category-add', 'uses' => 'Admin\CategoryController@productPost'] );
    Route::get( 'product-category/edit/{id}', ['as' => 'product-category-edit', 'uses' => 'Admin\CategoryController@productEdit'] );
    Route::post( 'product-category/edit/{id}', ['as' => 'product-category-edit', 'uses' => 'Admin\CategoryController@productStore'] );
    Route::get( 'product-category/del/{id}', ['as' => 'product-category-del', 'uses' => 'Admin\CategoryController@productDelete'] );
    Route::post( 'product-category/change-status', ['as'=>'product-category-status', 'uses'=> 'Admin\CategoryController@productChangeStatus'] );
    // **** CATEGORIES PRODUCT ****


    // **** PRODUCT ****
    Route::get( 'post', ['as' => 'post', 'uses' => 'Admin\PostController@index'] );
    Route::get( 'post/add', ['as' => 'post-add', 'uses' => 'Admin\PostController@addPost'] );
    Route::post( 'post/add', ['as' => 'post-add', 'uses' => 'Admin\PostController@postPost'] );
    Route::get( 'post/edit/{id}', ['as' => 'post-edit', 'uses' => 'Admin\PostController@editPost'] );
    Route::post( 'post/edit/{id}', ['as' => 'post-edit', 'uses' => 'Admin\PostController@storePost'] );
    Route::get( 'post/del/{id}', ['as' => 'post-del', 'uses' => 'Admin\PostController@delPost'] );
    Route::post( 'post/change-status', ['as'=>'post-status', 'uses'=> 'Admin\PostController@changeStatus'] );
    // **** PRODUCT ****

    // **** PRODUCT ****
    /* Route::get( 'product', ['as' => 'product', 'uses' => 'Admin\ProductController@index'] );
    Route::get( 'product/add', ['as' => 'product-add', 'uses' => 'Admin\ProductController@addProduct'] );
    Route::post( 'product/add', ['as' => 'product-add', 'uses' => 'Admin\ProductController@postProduct'] );
    Route::get( 'product/edit/{id}', ['as' => 'product-edit', 'uses' => 'Admin\ProductController@editProduct'] );
    Route::post( 'product/edit/{id}', ['as' => 'product-edit', 'uses' => 'Admin\ProductController@storeProduct'] );
    Route::get( 'product/del/{id}', ['as' => 'product-del', 'uses' => 'Admin\ProductController@delProduct'] );*/
    // **** PRODUCT ****

    // **** CONFIG ****
    Route::get( 'config/logo', ['as' => 'config-logo', 'uses' => 'Admin\ConfigController@logo'] );
    Route::get( 'config/info-footer', ['as' => 'config-footer', 'uses' => 'Admin\ConfigController@infoFooter'] );
    Route::post( 'config/logo', ['as' => 'config-logo', 'uses' => 'Admin\ConfigController@postLogo'] );
    Route::post( 'config/info-footer', ['as' => 'config-info-footer', 'uses' => 'Admin\ConfigController@postInfoFooter'] );
    // **** CONFIG ****
});
