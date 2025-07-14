<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InternshipApplicationController;
use App\Http\Controllers\AdminInternshipController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\LangTestController;
use App\Http\Controllers\ContactMessageController;
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/certificates/generate/{userId}', [CertificateController::class, 'generate']);
    Route::get('/certificates/{id}/download', [CertificateController::class, 'download']);
    Route::get('/my-certificates', [CertificateController::class, 'userCertificates']);
    Route::middleware('setlocale')->get('/welcome', [LangTestController::class, 'welcomeMessage']);
    Route::get('/interviews', [InterviewController::class, 'index']);
    Route::get('/interviews/{id}', [InterviewController::class, 'show']);
    Route::post('/contact', [ContactMessageController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('applications', InternshipApplicationController::class)->except(['store']);
    Route::post('/apply', [InternshipApplicationController::class, 'apply']);
    Route::get('/my-application', [InternshipApplicationController::class, 'myApplication']);
    Route::get('/interview/show/{applicationId}', [InterviewController::class, 'show']);
    Route::post('/notifications/read/{id}', function ($id) {
    auth()->user()->notifications()->where('id', $id)->first()?->markAsRead();
    return response()->json(['message' => 'Marked as read']);
});
    Route::get('/notifications', function (Request $request) {
        return $request->user()->unreadNotifications;
    });
});

Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
 Route::get('/admin/all-notifications', function (Request $request) {
    return $request->user()->notifications; // includes read + unread
});

   Route::get('/admin/contact-messages', [ContactMessageController::class, 'index']);
   Route::apiResource('admin/interviews', InterviewController::class);
   Route::get('/admin/applications', [AdminInternshipController::class, 'applications']);
   Route::post('/admin/application/{id}/status', [AdminInternshipController::class, 'updateStatus']);
   Route::get('/admin/applications', [AdminInternshipController::class, 'applications']);
});

