<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\ResidentialController;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\OurTeamController;
use App\Http\Controllers\ContactUsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */
//Login API
Route::post('login', [AuthController::class, 'login']);



Route::group(['prefix' => '/user-side'], function () {
    Route::get('/site-setting-show', [SiteSettingController::class, 'siteSettingShow']);
    Route::get('/show-about-us', [AboutUsController::class, 'showAboutUs']);
    Route::get('/show-all-residential', [ResidentialController::class, 'showAllResidential']);
    Route::post('/show-all-residential-detail', [ResidentialController::class, 'residentialDetail']);
    Route::get('/show-all-team-member', [OurTeamController::class, 'showAllOurTeam']);
    Route::get('/show-all-commercial', [CommercialController::class, 'showAllCommercial']);
    Route::get('/show-all-plot', [PlotController::class, 'showAllPlot']);
    Route::get('/show-all-gallery', [GalleryController::class, 'showAllGallery']);
});


// Contact Us Routes
Route::post('/contact-us-store', [ContactUsController::class, 'store']);

// Listing Routes
Route::get('/type-of-property-listing', [ResidentialController::class, 'typeOfPropertyList']);
Route::get('/status-of-property-listing', [ResidentialController::class, 'propertyStatus']);
Route::get('/amenity-of-property-listing', [ResidentialController::class, 'propertyAmenity']);
Route::get('/commercial-property-listing', [CommercialController::class, 'commercialType']);


Route::middleware('auth:api')->group(function () {

    // Profile Routes
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile_update', [AuthController::class, 'profile_update']);
    Route::post('logout', [AuthController::class, 'logout']);

    // Site Setting Routes
    Route::group(['prefix' => '/site-setting'], function () {
        Route::post('/store', [SiteSettingController::class, 'updateOrCreateSiteSetting']);
    });

    // Amenity Routes
    Route::group(['prefix' => '/amenity'], function () {
        Route::get('/index', [AmenityController::class, 'index']);
        Route::post('/store', [AmenityController::class, 'store']);
        Route::post('/show', [AmenityController::class, 'show']);
        Route::post('/update', [AmenityController::class, 'update']);
    });

    // Residential Routes
    Route::group(['prefix' => '/residential'], function () {
        Route::get('/index', [ResidentialController::class, 'index']);
        Route::post('/store', [ResidentialController::class, 'store']);
        Route::post('/show', [ResidentialController::class, 'show']);
        Route::post('/update', [ResidentialController::class, 'update']);
    });

    // Residential Gallery Routes
    Route::group(['prefix' => '/residential-gallery'], function () {
        Route::post('/index', [ResidentialController::class, 'indexResidentialGallery']);
        Route::post('/store', [ResidentialController::class, 'storeResidentialGallery']);
        Route::post('/delete', [ResidentialController::class, 'deleteResidentialGallery']);
    });

    // Residential Amenity Routes
    Route::group(['prefix' => '/residential-amenity'], function () {
        Route::post('/index', [ResidentialController::class, 'indexResidentialAmenity']);
        Route::post('/store', [ResidentialController::class, 'storeResidentialAmenity']);
        Route::post('/delete', [ResidentialController::class, 'deleteResidentialAmenity']);
    });

    // Plot Routes
    Route::group(['prefix' => '/plot'], function () {
        Route::get('/index', [PlotController::class, 'index']);
        Route::post('/store', [PlotController::class, 'store']);
        Route::post('/show', [PlotController::class, 'show']);
        Route::post('/update', [PlotController::class, 'update']);
    });

    // Commercial Routes
    Route::group(['prefix' => '/commercial'], function () {
        Route::get('/index', [CommercialController::class, 'index']);
        Route::post('/store', [CommercialController::class, 'store']);
        Route::post('/show', [CommercialController::class, 'show']);
        Route::post('/update', [CommercialController::class, 'update']);
    });

    // About Us Routes
    Route::group(['prefix' => '/about-us'], function () {
        Route::post('/store', [AboutUsController::class, 'updateOrCreateAboutUs']);
    });

    // Gallery Routes
    Route::group(['prefix' => '/gallery'], function () {
        Route::get('/index', [GalleryController::class, 'index']);
        Route::post('/store', [GalleryController::class, 'store']);
        Route::post('/delete', [GalleryController::class, 'delete']);
    });

    // Our Team Routes
    Route::group(['prefix' => '/our-team'], function () {
        Route::get('/index', [OurTeamController::class, 'index']);
        Route::post('/store', [OurTeamController::class, 'store']);
        Route::post('/show', [OurTeamController::class, 'show']);
        Route::post('/update', [OurTeamController::class, 'update']);
        Route::post('/delete', [OurTeamController::class, 'delete']);
    });

    // Contact Us Routes
    Route::get('/contact-us-show', [ContactUsController::class, 'show']);
});
