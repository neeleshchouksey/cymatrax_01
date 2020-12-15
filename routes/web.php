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

Route::get('/services', 'HomeController@services');
Route::get('/privacy', 'HomeController@privacy');
Route::get('/terms', 'HomeController@terms');

Route::get('/dashboard', 'UserController@index');
Route::get('/upload', 'UserController@upload_audio');
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

//Route::post('/directpayment', 'PaymentController@store');



