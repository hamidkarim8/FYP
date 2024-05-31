<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationSendController;
use  App\Http\Controllers\Auth\ForgotPasswordController;
use  App\Http\Controllers\Auth\ResetPasswordController;
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

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

Route::get('/pages-starter', [App\Http\Controllers\FoundItemController::class, 'index'])->name('pages-starter');
Route::get('/report', [App\Http\Controllers\ReportController::class, 'index']);
Route::get('/timeline', [App\Http\Controllers\HomeController::class, 'timeline'])->name('timeline');

Route::get('test', [App\Http\Controllers\HomeController::class, 'test']);
// Route::get('/index', [App\Http\Controllers\HomeController::class, 'count']);

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);


//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');


//forgot password
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('forgot-password-form');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


// Route::get('/test', function () {
//     return 'This is a test route.';
// });

Route::group(['middleware' => 'auth'],function(){
    Route::post('/store-token', [NotificationSendController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [NotificationSendController::class, 'sendNotification'])->name('send.web-notification');
});