<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('home', [ApiController::class,'home']);
Route::post('get-sub-categories', [ApiController::class,'getSubCategoriesById']);
Route::get('get-services', [ApiController::class,'getServices']);
Route::post('get-listings', [ApiController::class,'getListings']);
Route::post('get-listing-details', [ApiController::class,'getListingDetails']);
Route::post('submit-contact-us', [ApiController::class,'submitContactUs']);
Route::post('submit-list-your-business', [ApiController::class,'submitListYourBusiness']);