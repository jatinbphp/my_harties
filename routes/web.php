<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ListingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProfileUpdateController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
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

    Route::get('profile_update/getTransferKey', [ProfileUpdateController::class,'getTransferKey'])->name('profile_update.getTransferKey');
    Route::resource('profile_update', ProfileUpdateController::class);

    /*Common*/
    Route::post('common/changestatus', [CommonController::class,'changeStatus'])->name('common.changestatus');

    /* USER MANAGEMENT */
    Route::post('users/assign', [UserController::class,'assign'])->name('users.assign');
    Route::post('users/unassign', [UserController::class,'unassign'])->name('users.unassign');
    Route::resource('users', UserController::class);

    /* CATEGORY MANAGEMENT */
    Route::post('getSubCategory', [CategoryController::class,'getSubCategory'])->name('getSubCategory');
    Route::post('category/assign', [CategoryController::class,'assign'])->name('category.assign');
    Route::post('category/unassign', [CategoryController::class,'unassign'])->name('category.unassign');
    Route::resource('category', CategoryController::class);

    /* SUB CATEGORY MANAGEMENT */
    Route::post('sub_category/assign', [SubCategoryController::class,'assign'])->name('sub_category.assign');
    Route::post('sub_category/unassign', [SubCategoryController::class,'unassign'])->name('sub_category.unassign');
    Route::resource('sub_category', SubCategoryController::class);

    /* LISTINGS MANAGEMENT */
    Route::post('listings/assign', [ListingController::class,'assign'])->name('listings.assign');
    Route::post('listings/unassign', [ListingController::class,'unassign'])->name('listings.unassign');
    Route::post('listings/removeimage', [ListingController::class,'removeImage'])->name('listings.removeimage');
    Route::post('listings/sub-categories', [ListingController::class,'getSubCategories'])->name('listings.by_category');
    Route::resource('listings', ListingController::class);

    Auth::routes();
});

Route::get('/',[LoginController::class,'showAdminLoginForm'])->name('admin.login-view');
Route::get('/admin',[LoginController::class,'showAdminLoginForm'])->name('admin.login-view');
Route::post('/admin',[LoginController::class,'adminLogin'])->name('admin.login');
