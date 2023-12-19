<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\TwilioController;
use App\Http\Controllers\AssetJobController;
use App\Http\Controllers\Jobs\JobsController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\jobs\ExpeditedJobsController;
use App\Http\Controllers\Customers\CustomersController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\Technicians\TechnicianOffHours;
use App\Http\Controllers\Technicians\TechnicianController;
use App\Http\Controllers\Technicians\AssignTechnicianController;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return redirect('/login');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/callstatus/{id}', [TwilioController::class, 'status'])->name('callstatus');
Route::post('/gatherResponse/{id}', [TwilioController::class, 'gather'])->name('gatherResponses');


Auth::routes();
Route::middleware('admin')->group(function(){
    Route::controller(HomeController::class)->group(function(){
        Route::get('/home', 'index')->name('home');
        Route::get('/test', 'test'); 
    });

    Route::controller(CustomersController::class)->group(function(){

        Route::get('/customer', 'index')->name('customer');
        Route::get('/listCustomer', 'listing')->name('listCustomer');
        Route::post('/addCustomer', 'store')->name('addCustomer');
        Route::get('/editCustomer/{id}', 'editCustomers')->name('editCustomer');
        Route::post('/updateCustomer/{id}', 'update')->name('updateCustomer');
        Route::get('reset-password/{token}', 'showResetPasswordForm')->name('reset.password.get');

        Route::post('reset-password', 'submitResetPasswordForm')->name('reset.password.post');
        Route::get('/deleteCustomer/{user}', 'destroy')->name('deleteCustomer');
        Route::get('/changeStatus','changeStatus')->name('changeStatus');
    });

    Route::controller(TechnicianController::class)->group(function(){

        Route::get('/technician','index')->name('technician')->middleware('admin');
        Route::get('/listTechnician','listing')->name('listTechnician')->middleware('admin');
        Route::post('/addTechnician','store')->name('addTechnician')->middleware('admin');
        Route::get('/editTechnician/{id}','editTechnician')->name('editCustomer')->middleware('admin');
        Route::post('/updateTechnician/{id}','update')->name('updateCustomer')->middleware('admin');
        Route::get('reset-password/{token}','showResetPasswordForm')->name('reset.password.get')->middleware('admin');
        Route::get('changeStatus','status')->name('changeStatus.status')->middleware('admin');

        Route::post('reset-password','submitResetPasswordForm')->name('reset.password.post')->middleware('admin');
        Route::get('/deleteTechnician/{user}','destroy')->name('deleteTechnician');
    });

    Route::controller(App\Http\Controllers\ImportAssets\ImportAssetController::class)->group(function(){
        Route::get('/importAsset','index')->name('importAsset')->middleware('admin');

        Route::post('/importData','uploadAssets')->name('importData')->middleware('admin');

        Route::get('/allAssets','listing')->name('allAssets')->middleware('admin');

    });

    Route::controller(JobsController::class)->middleware('admin')->group(function(){
        Route::get('/jobs', 'index')->name('jobs.index');
        Route::get('/jobDetails/{job}', 'show')->name('jobs.show');
        Route::post('job/{job}', 'update')->name('job.update');
    });

    Route::controller(AssetJobController::class)->middleware('admin')->group(function(){
        Route::get('/asset', 'create')->name('asset.create');
        Route::post('/asset', 'store')->name('asset.store');
        Route::get('/asset/{job}', 'show')->name('asset.show');
        Route::post('asset/{asset}', 'update')->name('asset.update');
    });

    Route::controller(AssetsController::class)->middleware('admin')->group(function(){
        Route::get('/assets', 'index')->name('assets.index');
        Route::get('/asset', 'create')->name('asset.create');
        Route::post('/asset', 'store')->name('asset.store');
        Route::post('/asset/{asset}', 'update')->name('asset.update');
        Route::get('/assetDetails/{asset}', 'show')->name('asset.show');
        Route::get('/assetDelete/{asset}', 'destroy')->name('asset.destroy');
    });

    Route::controller(AssignTechnicianController::class)->middleware('admin')->group(function(){
        Route::get('technician/{job}', 'index')->name('technician.index');
        Route::post('technician/{job}', 'store')->name('technician.store');
    });

    Route::controller(TechnicianOffHours::class)->middleware('admin')->group(function () {
        Route::get('technicianOffHours', 'index')->name('technicianOffHours.index');
        Route::get('OffHourscreate', 'create')->name('OffHourscreate.create');
        Route::post('offHoursStore', 'store')->name('offHoursStore.store');
    });

    Route::controller(ExpeditedJobsController::class)->middleware('admin')->group(function() {
        Route::get('expeditedJobs', 'index')->name('expeditedJobs.index');
    });

    Route::controller(AdminProfileController::class)->middleware('admin')->group(function() {
        Route::get('profile', 'show')->name('profile.show');
        Route::post('profile', 'update')->name('profile.pdate');
    });
    
    
});
Route::get('/support', function() {
    return view('support');
});
Route::get('/{number}', [DownloadController::class, 'index'])->name('download.app');


