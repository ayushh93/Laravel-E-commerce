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

Route::get('/', 'IndexController@index')->name('index');

Route::prefix('/admin')->group(function(){
    //admin login
    Route::match(['get', 'post'], '/login', 'AdminLoginController@adminLogin')->name('adminLogin');

    Route::group(['middleware' => ['admin']], function(){
        //admin dashboard
        Route::get('/dashboard', 'AdminLoginController@dashboard')->name('adminDashboard');
        //admin profile
        Route::get('/profile', 'AdminProfileController@profile')->name('profile');
        //admin update
        Route::post('/profile/update/{id}', 'AdminProfileController@updateProfile')->name('updateProfile');
        // Change password
        Route::get('/profile/change_password', 'AdminProfileController@changePassword')->name('changePassword');
        // Check Current Password
        Route::post('/profile/check-password', 'AdminProfileController@chkUserPassword')->name('chkUserPassword');
        // Update Admin Password
         Route::post('/profile/update_password/{id}', 'AdminProfileController@updatePassword')->name('updatePassword');


         //category routes
         Route::get('/category', 'CategoryController@category')->name('category.index');
         Route::get('/category/add', 'CategoryController@addCategory')->name('addCategory');
         Route::post('/category/add', 'CategoryController@storeCategory')->name('storeCategory');
        Route::get('/category/edit/{id}', 'CategoryController@editCategory')->name('editCategory');
        Route::post('/category/edit/{id}', 'CategoryController@updateCategory')->name('updateCategory');
        Route::get('/delete-category/{id}','CategoryController@deleteCategory')->name('deleteCategory');
        Route::post('/update-category-status','CategoryController@updateCategoryStatus')->name('updateCategoryStatus');

        //theme settings
        Route::get('/theme','ThemeController@theme')->name('theme');
        Route::post('/theme/{id}','ThemeController@themeUpdate')->name('themeUpdate');

        //product
        Route::get('/product','ProductsController@product')->name('product.index');
        Route::get('/product/add', 'ProductsController@addProduct')->name('addProduct');
        Route::post('/product/store','ProductsController@storeProduct')->name('storeProduct');
        Route::get('/product/edit/{id}','ProductsController@editProduct')->name('editProduct');
        Route::post('/product/update/{id}','ProductsController@updateProduct')->name('updateProduct');
        Route::get('/delete-product/{id}','ProductsController@deleteProduct')->name('deleteProduct');


    });
});
Route::post('/ckeditor','CkeditorFileUploadController@store')->name('ckeditor.upload');
Route::get('/admin/logout', 'AdminLoginController@adminLogout' )->name('adminLogout');
Route::match(['get','post'], '/forget-password','AdminLoginController@forgetPassword')->name('forgetPassword');

