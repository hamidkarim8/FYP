<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ClaimController;
use Illuminate\Support\Facades\Auth;


Auth::routes();

// Landing page route accessible to all users
Route::get('/', [HomeController::class, 'root'])->name('root');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('forgot-password-form');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Admin Dashboard Route
Route::get('/admin', [AdminController::class, 'adminIndex'])->middleware(['auth', 'role:admin'])->name('admin.index');

// Admin Reports
Route::get('/reports', [AdminController::class, 'displayReports'])->middleware(['auth', 'role:admin'])->name('admin.displayReports');
Route::get('/get-reports', [AdminController::class, 'getReports'])->middleware(['auth', 'role:admin'])->name('admin.getReports');
Route::get('admin/reports/{id}', [AdminController::class, 'viewReport'])->middleware(['auth', 'role:admin'])->name('admin.viewReport');
Route::delete('admin/reports/{id}', [AdminController::class, 'deleteReport'])->middleware(['auth', 'role:admin'])->name('admin.deleteReport');

// Admin Admins
Route::get('/admins', [AdminController::class, 'displayAdmins'])->middleware(['auth', 'role:admin'])->name('admin.displayAdmins');
Route::get('/get-admins', [AdminController::class, 'getAdmins'])->middleware(['auth', 'role:admin'])->name('admin.getAdmins');
Route::get('admin/admins/{id}', [AdminController::class, 'viewAdmin'])->middleware(['auth', 'role:admin'])->name('admin.viewAdmin');
Route::delete('admin/admins/{id}', [AdminController::class, 'deleteAdmin'])->middleware(['auth', 'role:admin'])->name('admin.deleteAdmin');
Route::post('/admin/store', [AdminController::class, 'store'])->middleware(['auth', 'role:admin'])->name('admin.store');

// Admin Users
Route::get('/users', [AdminController::class, 'displayUsers'])->middleware(['auth', 'role:admin'])->name('admin.displayUsers');
Route::get('/get-users', [AdminController::class, 'getUsers'])->middleware(['auth', 'role:admin'])->name('admin.getUsers');
Route::get('admin/users/{id}', [AdminController::class, 'viewUser'])->middleware(['auth', 'role:admin'])->name('admin.viewUser');
Route::delete('admin/users/{id}', [AdminController::class, 'deleteUsers'])->middleware(['auth', 'role:admin'])->name('admin.deleteUsers');

// Admin Feedbacks
Route::get('/feedbacks', [AdminController::class, 'displayFeedbacks'])->middleware(['auth', 'role:admin'])->name('admin.displayFeedbacks');
Route::get('/get-feedbacks', [AdminController::class, 'getFeedbacks'])->middleware(['auth', 'role:admin'])->name('admin.getFeedbacks');
Route::get('admin/feedbacks/{id}', [AdminController::class, 'viewFeedback'])->middleware(['auth'])->name('admin.viewFeedback');
Route::delete('admin/feedbacks/{id}', [AdminController::class, 'deleteFeedback'])->middleware(['auth', 'role:admin'])->name('admin.deleteFeedback');
Route::post('/admin/replyFeedback', [AdminController::class, 'replyFeedback'])->middleware(['auth', 'role:admin'])->name('admin.replyFeedback');
Route::post('/admin/toggleDisplay', [AdminController::class, 'toggleDisplay'])->middleware(['auth', 'role:admin'])->name('admin.toggleDisplay');

// User Home Route
Route::get('/home', [UserController::class, 'userIndex'])->middleware(['auth', 'role:normal_user'])->name('user.index');
Route::get('/my-reports', [UserController::class, 'myReports'])->middleware(['auth', 'role:normal_user'])->name('user.myReports');

// Profile Routes
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::get('/user-profile', [ProfileController::class, 'showUserProfile'])->name('user.profile');
Route::post('/update-profile/{id}', [ProfileController::class, 'update'])->name('updateProfile');
Route::post('/update-socialmedia/{id}', [ProfileController::class, 'updateSocialMedia'])->name('updateSocialMedia');
Route::post('/update-avatar/{id}', [ProfileController::class, 'updateAvatar'])->name('updateAvatar');
Route::post('/update-password/{id}', [ProfileController::class, 'changePassword'])->name('changePassword');

//Item Detail Route
Route::get('/item-detail/{id:uuid}', [ItemController::class, 'itemDetail'])->middleware(['auth', 'role:normal_user'])->name('user.itemDetail');
Route::get('/user/latest-report', [ItemController::class, 'latestReport'])->name('user.latestReport');
Route::get('/item/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
Route::post('/item/update/{id}', [ItemController::class, 'update'])->name('item.update');
Route::delete('/item/delete/{id}', [ItemController::class, 'delete'])->name('item.delete');
Route::post('/item/resolved/{id}', [ItemController::class, 'resolved'])->name('item.resolved');
Route::get('/item/getApprovedRequests/{id}', [RequestController::class, 'getApprovedRequests']);

//Simple Report
Route::post('/simple-report', [ReportController::class, 'storeSimpleReport'])->name('simple-reports.store');
Route::post('/simple-report-display', [ReportController::class, 'showSimpleReport'])->name('simple-reports.show');
Route::get('/categories', [CategoryController::class, 'index']);

//Detailed Report
Route::post('/uploads', [ReportController::class, 'process'])->name('uploads.process');
Route::post('/detailed-report', [ReportController::class, 'submitDetailedReport'])->name('submit.detailed.report');

//Request to contact/PoO
Route::post('/reports/{report}/request-action', [RequestController::class, 'requestAction']);
Route::post('/accept-request/{requestId}', [RequestController::class, 'acceptRequestById']);
Route::post('/decline-request/{requestId}', [RequestController::class, 'declineRequestById']);
Route::get('/reports/{reportId}/requests', [RequestController::class, 'getRequests']);

//Notification
Route::get('/notifications', [NotificationController::class, 'fetchNotifications'])->name('notifications.fetch');
Route::put('/notifications/{notificationId}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
Route::put('/notifications/{notificationId}/mark-as-unread', [NotificationController::class, 'markAsUnread'])->name('notifications.mark-as-unread');

//Feedback
Route::post('/feedback', [FeedbackController::class, 'store'])->middleware('auth');

//Contact send email
Route::post('/send-email', [ContactController::class, 'sendEmail'])->name('sendEmail');

//Claimer Information
Route::get('/fetchClaimerInfo/{reportId}', [ClaimController::class, 'fetchClaimerInfo']);

// Fallback Route
Route::fallback(function () {
    return redirect()->route('root');
});
