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
Route::get('send-csv-email', 'UserController@sendCsvEmail');
Route::get('/upload-summary/{id}', 'UserController@upload_summary');
Route::get('/transactions', 'UserController@transactions');
Route::get('/transaction-details/{id}','UserController@transaction_details');
Route::get('/audio-analysis/{id}','UserController@audio_analysis');
Route::get('/download-file/{file}','UserController@download_file');
Route::get('/checkout/{id}', 'PaymentController@checkout');
Route::post('/multiple-checkout', 'PaymentController@multiple_checkout');
Route::post('/payment/store', 'PaymentController@store');
Route::get('/checkout-single/{id}', 'PaymentController@checkout_single');
Route::get('/clean-files/{id}', 'PaymentController@clean_files');
Route::get('/clean-files-with-free-trial/{id}', 'PaymentController@clean_files_with_free_trial');
Route::post('/clean-multiple-files-with-free-trial', 'PaymentController@clean_multiple_files_with_free_trial');
Route::get('/clean-file/{id}', 'PaymentController@clean_file');
Route::post('/clean-multiple-file', 'PaymentController@clean_multiple_file');
Route::get('/get-account-audio/{value}','UserController@getAccountAudio');
Route::get('/get-transaction-audio/{id}','UserController@getTransactionAudio');
Route::get('/get-uploaded-audio/{id}','UserController@getUploadedAudio');
Route::get('/get-audio/{id}','UserController@getAudio');
Route::get('/free-subscription','UserController@free_subscription');
Route::get('/confirm-subscription','UserController@confirm_subscription');

###################### Admin Routes ##########################

Route::get('/admin', 'AdminController@login')->name('admin.login');
Route::post('/admin/login', 'AdminController@admin_login');

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/unauthorize-access', 'AdminController@unauthorize_access');
    Route::get('/logout', 'AdminController@logout');
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard')->middleware('role:dashboard');
    Route::get('/free-subscription', 'AdminController@free_subscription')->middleware('role:free-subscription');
    Route::get('/file-delete-setting','AdminController@file_delete_setting');
    Route::get('/users', 'AdminController@users')->name('admin.users')->middleware('role:users');
    Route::get('/user-files/{id}','AdminController@user_files');
    Route::get('/get-user-files/{id}','AdminController@get_user_files');
    Route::get('/admins', 'AdminController@admins')->name('admin.admins')->middleware('role:admins');
    Route::get('/roles', 'AdminController@roles')->name('admin.roles')->middleware('role:roles');

    Route::post('/update-free-subscription-days', 'AdminController@update_free_subscription_days');
    Route::post('/update-file-delete-days', 'AdminController@update_file_delete_days');
    Route::get('/delete-file/{id}', 'AdminController@delete_file');
    Route::get('/get-all-users', 'AdminController@get_users');
    Route::post('/activate-deactivate-user', 'AdminController@activate_deactivate_user');
    Route::get('/reset-trial/{id}', 'AdminController@reset_trial');

    Route::get('/get-all-admins', 'AdminController@get_admins');
    Route::post('/add-admin', 'AdminController@add_admin')->name('admin.add-admin');
    Route::post('/activate-deactivate-admin', 'AdminController@activate_deactivate_admin');

    Route::get('/get-admin/{id}', 'AdminController@get_admin');
    Route::post('/update-admin', 'AdminController@update_admin')->name('admin.update-admin');

    Route::get('/get-all-roles', 'AdminController@get_roles');
    Route::get('/get-role/{id}', 'AdminController@get_role');
    Route::post('/update-role', 'AdminController@update_role');

});
