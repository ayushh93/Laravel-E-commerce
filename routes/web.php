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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/admin')->group(function(){
    //admin login
    Route::match(['get', 'post'], '/login', 'AdminLoginController@adminLogin')->name('adminLogin');
    
    Route::group(['middleware' => ['admin']], function(){
        //admin dashboard
        Route::get('/dashboard', 'AdminLoginController@dashboard')->name('adminDashboard');
    });
});

Route::get('/admin/logout', 'AdminLoginController@adminLogout' )->name('adminLogout');

