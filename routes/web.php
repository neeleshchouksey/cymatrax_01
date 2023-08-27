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
Route::post('/register', 'Auth\RegisterController@doRegister')->name('do-register');
Route::get('send-verify-email/{email}', 'Auth\LoginController@sendVerifyEmail')->name('send-verify-email');
Route::get('auth/google', 'GoogleController@loginWithGoogle')->name('login-with-google');
Route::any('auth/google/callback', 'GoogleController@callbackFromGoogle')->name('callback-google');
Route::get('verify-user/{id}', 'Auth\RegisterController@verifyEmail')->name('verify-user');
Route::get('open-inbox', 'Auth\RegisterController@openInbox')->name('open-inbox');
Route::get('/services', 'HomeController@services');
Route::get('/privacy', 'HomeController@privacy');
Route::get('/terms', 'HomeController@terms');
Route::get('/dashboard', 'UserController@index')->name('userDashboard');
Route::get('/upload-audio', 'UserController@upload_audio')->name('uploadAudio');
Route::get('/profile', 'UserController@profile')->name('userProfile');
Route::post('/update-profile', 'UserController@update_profile')->name("update-profile");
Route::post('file/upload', 'UserController@upload')->name('file.upload');
Route::post('download-file', 'UserController@download');
Route::post('save-duration', 'UserController@save_duration');
Route::get('account', 'UserController@account')->name('my_account');
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
Route::get('/subscription','UserController@subscription')->name('subscription');
// Route::get('')
Route::get('/payments/create/{id}','PaypalController@createView')->name('paymentCreateView');
Route::post('/payments/process','PaypalController@paymentProcess')->name('paymentProcess');
Route::get('/payments/success','PaypalController@paymentSuccess')->name('paymentSuccess');
Route::get('/payments/cancel','PaypalController@paymentCancel')->name('paymentCancel');
Route::get('create-product','PaypalController@createProduct')->name('createProduct');
Route::get('create-plan','PaypalController@createPlan')->name('createPlan');
Route::get('generate-token','PaypalController@generateAccessToken')->name('generateAccessToken');

Route::get('new-subscription', 'PaypalController@test')->name('test');
// Route::post('subscription', 'PaypalController@subscription')->name('subscription');
Route::post('/pay-via-paypal','UserController@redirectToPayment');
Route::get('/paymentinfo', 'UserController@redirectToPayInfo');





###################### Admin Routes ##########################

Route::get('/admin', 'AdminController@login')->name('admin.login');
Route::post('/admin/login', 'AdminController@admin_login');

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/unauthorize-access', 'AdminController@unauthorize_access');
    Route::get('/logout', 'AdminController@logout');
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard')->middleware('role:dashboard');
    Route::get('/free-subscription', 'AdminController@free_subscription')->middleware('role:free-subscription');
    Route::get('/time-on-disk', 'AdminController@time_on_disk')->middleware('role:time-on-disk');
    Route::get('/clean-file-limit','AdminController@file_delete_setting');
    Route::get('/users', 'AdminController@users')->name('admin.users')->middleware('role:users');
    Route::get('/user-files/{id}','AdminController@user_files');
    Route::get('/view/{id}','AdminController@view_user_files');
    Route::get('/get-user-files/{id}','AdminController@get_user_files');
    Route::get('/view-user-files/{id}','AdminController@view_get_user_files');
    Route::get('/admins', 'AdminController@admins')->name('admin.admins')->middleware('role:admins');
    Route::get('/roles', 'AdminController@roles')->name('admin.roles')->middleware('role:roles');
    Route::get('/plan-and-subscription', 'AdminController@plan_and_subscription')->name('admin.roles')->middleware('role:plan-and-subscription');
    Route::get('/reports', 'AdminController@reports')->name('admin.reports')->middleware('role:reports');

    Route::post('/update-free-subscription-days', 'AdminController@update_free_subscription_days');
    Route::post('/update-time-on-disk', 'AdminController@update_time_on_disk');
    Route::post('/update-file-delete-days', 'AdminController@update_file_delete_days')->name('update-file-delete');
    Route::get('/delete-file/{id}', 'AdminController@delete_file');
    Route::get('/get-all-users', 'AdminController@get_users');
    Route::get('/get-all-reports', 'AdminController@get_reports');
    Route::post('/activate-deactivate-user', 'AdminController@activate_deactivate_user');
    Route::post('/delete-user', 'AdminController@delete_user');
    Route::post('/make-remove-enterprise-user', 'AdminController@make_remove_enterprise_user');
    Route::get('/reset-trial/{id}', 'AdminController@reset_trial');
    Route::get('/subscription/{id}', 'AdminController@subscription');

    Route::get('/get-all-admins', 'AdminController@get_admins');
    Route::post('/add-admin', 'AdminController@add_admin')->name('admin.add-admin');
    Route::post('/activate-deactivate-admin', 'AdminController@activate_deactivate_admin');

    Route::get('/get-admin/{id}', 'AdminController@get_admin');
    Route::post('/update-admin', 'AdminController@update_admin')->name('admin.update-admin');

    Route::get('/get-all-roles', 'AdminController@get_roles');
    Route::post('/update-role', 'AdminController@update_role');
    Route::get('/get-role/{id}', 'AdminController@get_role');
    Route::get('/get-all-plans', 'AdminController@get_plans');
    Route::post('/update-plan', 'AdminController@update_plan');
    Route::get('/get-plan/{id}', 'AdminController@get_plan');

    // Constat Menu Route 27 Aug 

    Route::get('/constant-settings', 'AdminController@constant_settings')->middleware('role:constant-settings');
    Route::get('/get-all-constant', 'AdminController@get_constant_setting');
    Route::get('/get-all-const/{id}', 'AdminController@get_const');
    Route::post('/update-constant-settings', 'AdminController@update_constant_settings');

    

});
