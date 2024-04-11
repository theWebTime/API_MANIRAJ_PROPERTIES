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
    Route::get('/show-all-amenity', [AmenityController::class, 'showAllAmenity']);
    Route::get('/show-all-residential', [ResidentialController::class, 'showAllResidential']);
    Route::get('/show-all-residential-gallery', [ResidentialController::class, 'showAllResidentialGallery']);
    Route::get('/show-all-plot', [PlotController::class, 'showAllPlot']);
    Route::get('/show-about-us', [AboutUsController::class, 'showAboutUs']);
    Route::get('/show-all-gallery', [GalleryController::class, 'showAllGallery']);
    Route::get('/show-all-team-member', [GalleryController::class, 'showAllOurTeam']);
});

Route::get('/amenity-show/{id}', [AmenityController::class, 'show']);
Route::get('/residential-show/{id}', [ResidentialController::class, 'show']);
Route::get('/plot-show/{id}', [PlotController::class, 'show']);
Route::get('/commercial-show/{id}', [CommercialController::class, 'show']);
Route::get('/our-team-show/{id}', [OurTeamController::class, 'show']);

// Contact Us Routes
Route::post('/contact-us-store', [ContactUsController::class, 'store']);

Route::middleware('auth:api')->group(function () {

    // Site Setting Routes
    Route::group(['prefix' => '/site-setting'], function () {
        Route::post('/store', [SiteSettingController::class, 'updateOrCreateSiteSetting']);
    });

    // Amenity Routes
    Route::group(['prefix' => '/amenity'], function () {
        Route::get('/index', [AmenityController::class, 'index']);
        Route::post('/store', [AmenityController::class, 'store']);
        Route::post('/update/{id}', [AmenityController::class, 'update']);
    });

    // Residential Routes
    Route::group(['prefix' => '/residential'], function () {
        Route::get('/index', [ResidentialController::class, 'index']);
        Route::post('/store', [ResidentialController::class, 'store']);
        Route::post('/update/{id}', [ResidentialController::class, 'update']);
    });

    // Residential Gallery Routes
    Route::group(['prefix' => '/residential-gallery'], function () {
        Route::get('/index/{id}', [ResidentialController::class, 'indexResidentialGallery']);
        Route::post('/store/{id}', [ResidentialController::class, 'storeResidentialGallery']);
        Route::post('/delete/{id}', [ResidentialController::class, 'deleteResidentialGallery']);
    });

    // Plot Routes
    Route::group(['prefix' => '/plot'], function () {
        Route::get('/index', [PlotController::class, 'index']);
        Route::post('/store', [PlotController::class, 'store']);
        Route::post('/update/{id}', [PlotController::class, 'update']);
    });

    // Commercial Routes
    Route::group(['prefix' => '/commercial'], function () {
        Route::get('/index', [CommercialController::class, 'index']);
        Route::post('/store', [CommercialController::class, 'store']);
        Route::post('/update/{id}', [CommercialController::class, 'update']);
    });

    // About Us Routes
    Route::group(['prefix' => '/about-us'], function () {
        Route::post('/store', [AboutUsController::class, 'updateOrCreateAboutUs']);
    });

    // Gallery Routes
    Route::group(['prefix' => '/gallery'], function () {
        Route::get('/index', [GalleryController::class, 'index']);
        Route::post('/store', [GalleryController::class, 'store']);
        Route::post('/delete/{id}', [GalleryController::class, 'delete']);
    });

    // Our Team Routes
    Route::group(['prefix' => '/our-team'], function () {
        Route::get('/index', [OurTeamController::class, 'index']);
        Route::post('/store', [OurTeamController::class, 'store']);
        Route::post('/delete/{id}', [OurTeamController::class, 'delete']);
    });

    // Contact Us Routes
    Route::get('/contact-us-show', [ContactUsController::class, 'show']);
});
