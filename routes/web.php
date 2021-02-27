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

Auth::routes();

Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::get('/services', 'HomeController@services');
Route::get('/privacy', 'HomeController@privacy');
Route::get('/terms', 'HomeController@terms');
Route::get('/dashboard', 'UserController@index');
Route::get('/upload-audio', 'UserController@upload_audio');
Route::get('/profile', 'UserController@profile');
Route::post('/update-profile', 'UserController@update_profile')->name("update-profile");
Route::post('file/upload', 'UserController@upload')->name('file.upload');
Route::get('account', 'UserController@account');
Route::get('/upload-summary/{id}', 'UserController@upload_summary');
Route::get('/transactions', 'UserController@transactions');
Route::get('/transaction-details/{id}','UserController@transaction_details');
Route::get('/audio-analysis/{id}','UserController@audio_analysis');
Route::get('/download-file/{file}','UserController@download_file');
Route::get('/checkout/{id}', 'PaymentController@checkout');
Route::post('/payment/store', 'PaymentController@store');
Route::get('/checkout-single/{id}', 'PaymentController@checkout_single');
Route::get('/clean-files/{id}', 'PaymentController@clean_files');
Route::get('/clean-file/{id}', 'PaymentController@clean_file');
Route::get('/get-account-audio','UserController@getAccountAudio');
Route::get('/get-transaction-audio/{id}','UserController@getTransactionAudio');
Route::get('/get-uploaded-audio/{id}','UserController@getUploadedAudio');
Route::get('/free-subscription','UserController@free_subscription');
Route::get('/confirm-subscription','UserController@confirm_subscription');


###################### Admin Routes ##########################

Route::get('/admin', 'AdminController@login')->name('admin.login');
Route::post('/admin/login', 'AdminController@admin_login');

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/logout', 'AdminController@logout');
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('/free-subscription', 'AdminController@free_subscription')->name('admin.dashboard');
    Route::post('/update-free-subscription-days', 'AdminController@update_free_subscription_days');
});
