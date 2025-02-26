<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ListingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProfileUpdateController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\ListYourBusinessController;
use App\Http\Controllers\Admin\EmergenciesController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

;
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
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('logout', [LoginController::class,'logout']);

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    /*IMAGE UPLOAD IN SUMMER NOTE*/
    Route::post('image/upload', [ImageController::class,'upload_image']);

    //Edit Profile
    Route::resource('profile_update', ProfileUpdateController::class);

    /*Common*/
    Route::post('common/changestatus', [CommonController::class,'changeStatus'])->name('common.changestatus');

    /* USER MANAGEMENT */
    Route::resource('users', UserController::class);

    /* CATEGORY MANAGEMENT */
    Route::post('getSubCategory', [CategoryController::class,'getSubCategory'])->name('getSubCategory');
    Route::resource('category', CategoryController::class);

    /* SUB CATEGORY MANAGEMENT */
    Route::resource('sub_category', SubCategoryController::class);

    /* LISTINGS MANAGEMENT */
    Route::post('listings/removeimage', [ListingController::class,'removeImage'])->name('listings.removeimage');
    Route::post('listings/sub-categories', [ListingController::class,'getSubCategories'])->name('listings.by_category');
    Route::post('listings-additional-fields-data', [ListingController::class,'additionalFieldsData'])->name('listings.additional_fields_data');
    Route::get('listings/import-listings', [ListingController::class,'importListings'])->name('listings.import.listing');
    Route::post('listings/import-listings-store', [ListingController::class,'importListingsStore'])->name('listings.import.listing.store');
    Route::resource('listings', ListingController::class);
    Route::delete('listings/delete-special-instruction/{id}', [ListingController::class,'deleteSpecialInstruction'])
    ->name('special-instruction.delete');


    /*Contact Us*/
    Route::resource('contactus', ContactUsController::class);

    /*Contact Us*/
    Route::resource('list-your-business', ListYourBusinessController::class);

    /*Emergencies*/
    Route::resource('emergencies-update', EmergenciesController::class);

    /*Reports*/
    Route::get('reports/listing_expiring', [ReportController::class, 'listing_expiring'])->name('reports.listing_expiring');
    Route::get('reports/all_users', [ReportController::class, 'all_users'])->name('reports.all_users');
    Route::get('reports/paid_listings', [ReportController::class, 'paid_listings'])->name('reports.paid_listings');

    Auth::routes();
});

Route::get('/',[LoginController::class,'showAdminLoginForm'])->name('admin.login-view');
Route::get('/admin',[LoginController::class,'showAdminLoginForm'])->name('admin.login-view');
Route::post('/admin',[LoginController::class,'adminLogin'])->name('admin.login');
Route::get('/listing/details/{id}',[HomeController::class,'index'])->name('listing.details');