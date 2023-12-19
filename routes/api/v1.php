<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JobsController;
use App\Http\Controllers\Api\AssetsController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AssetTypeController;
use App\Http\Controllers\Api\AttachmentController;
use App\Http\Controllers\Api\JobPriorityController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\CustomerPasswordController;

Route::prefix('v1')->group(function () {
    Route::controller(App\Http\Controllers\Api\UserController::class)->group(function(){
        Route::post('login','login')->name('login');
        Route::post('logout','logout_customer')->name('logout')->middleware('auth:api');
        Route::get('job-details','get_jobs')->name('job-details')->middleware('auth:api');
        Route::post('forgot-password','forgot_password');
    });

    Route::controller(ProfileController::class)->group(function(){
        Route::middleware('auth:api')->group(function (){
            Route::get('profile', 'show')->name('profile.show');
            Route::put('profile', 'update')->name('profile.update');
        });
    });

    Route::controller(JobsController::class)->middleware('auth:api')->group(function(){
        Route::post('jobs','store')->name('jobs.store');
        Route::get('jobs', 'index')->name('jobs.index');
        Route::get('jobs/{job}', 'show')->name('jobs.show');
        Route::post('jobs/{job}', 'update')->name('jobs.update');
    });

    Route::controller(AssetsController::class)->middleware('auth:api')->group(function(){
        Route::post('get-asset-id','craeteAsset')->name('getassetid');
        Route::get('assets','index')->name('asset.index');
        Route::get('assets/{asset}','show')->name('asset.show');
        Route::post('assets', 'store')->name('assets.store');
        Route::post('assets/{asset}', 'update')->name('assets.update');
    });

    Route::controller(AssetTypeController::class)->middleware('auth:api')->group(function() {
        Route::get('asset-types', 'index')->name('asset-types.index');
    });
  
    Route::controller(JobPriorityController::class)->middleware('auth:api')->group(function(){
        Route::get('job-priorities', 'index')->name('job-priorities.index');
    });

    Route::controller(AttachmentController::class)->middleware('auth:api')->group(function(){
        Route::delete('attachment/{file}', 'destroy')->name('attachment.destroy');
    });

    Route::controller(CustomerPasswordController::class)->middleware('auth:api')->group(function(){
        Route::post('change-password', 'update')->name('change-password.update');
    });

    Route::controller(NotificationController::class)->middleware('auth:api')->group(function(){
        Route::get('notifications', 'index')->name('notifications.index');
    });
});