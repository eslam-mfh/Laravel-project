<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdviceController;
use App\Http\Controllers\BookOffersController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ServiceSpecialistController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SpecialistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
//use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\serviceController ;
use App\Http\Controllers\OfferController ;
use App\Http\Controllers\OfferServiceController ;
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
Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [AuthController::class, "profile"]);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/switch-account', [AuthController::class, 'switchAccount']);
    Route::delete('/user', [AuthController::class, 'destroy']);
});

Route::post('login', [AuthController::class, "login"]);
Route::post('register', [AuthController::class, "register"]);
Route::post('logout', [AuthController::class, "logout"]);


Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'ResetPassword']);
Route::post('logino', [AuthController::class, "logindashboard"]);



//-------------------------------------------------------------------------------------------------
Route::get('Categories' , [CategoryController::class , 'index']) ; //categories
Route::get('Category/{id}' , [CategoryController::class , 'show']) ; //category details
Route::get('specialists' , [specialistController::class , 'index']); //show specialists
Route::get('topServices' , [serviceController::class, 'index']) ; //top services
Route::get('Services/{id}' , [serviceController::class, "getCategory"]) ; //services names for specific category
Route::get('seviceDetails/{id}' ,[ServiceController::class , "service"]) ; //sservice details
Route::get('offers' , [OfferController::class , 'index']) ; //offers
Route::get('soonoffers' , [OfferController::class , 'soon']) ; //offers
Route::get('offersServices/{id}' , [OfferController::class , 'services']) ; //offers س
Route::get('/service-specialist/{service_id}/specialist-names', [ServiceSpecialistController::class, 'getSpecialistNamesByServiceId']);

Route::get('/location', [AboutUsController::class, 'getLocation']);
Route::get('/socialLinks', [AboutUsController::class, 'index']);
Route::post('upload', [MediaController::class, 'upload']);//upload before & after
Route::get('media', [MediaController::class, 'index']); //show before & after
Route::post('/writeAdvice', [AdviceController::class, 'store']); //write advice
Route::get('/advice', [AdviceController::class, 'index']); // show advice
Route::get('reviews', [ReviewsController::class, 'getApprovedReviews']);//available slot for specialist
Route::get('rates', [ReviewsController::class, 'averageRating']);
///////////////////


Route::middleware('auth')->group(function () {
    Route::get('sessions/pending', [SessionController::class, 'getPendingSessions']);
    Route::get('/sessions/approved', [SessionController::class, 'getApprovedSessions']);
    Route::get('/sessions/refused', [SessionController::class, 'getRefusedSessions']);

    Route::get('/sessions/completed', [SessionController::class, 'getCompletedSessions']);
    Route::put('sessions/update/{id}', [SessionController::class, 'updateSession']);
    Route::delete('/sessions/delete/{id}', [SessionController::class, 'deleteSession']);
    Route::post('review/{sessionId}', [ReviewsController::class, 'writeReview']);


    Route::get('available/{service_id}/{specialist_id}', [SpecialistController::class, 'available']);//available slot for specialist
    Route::post('slots/{id}/book', [specialistController::class, 'bookSlot']); //reservation
    ////////
    Route::get('availableslot/{offer_id}', [BookOffersController::class, 'availableforoffer']);//available slot for specialist
    Route::post('offer/{offer_id}', [BookOffersController::class, 'bookSlotforoffer']); //reservation
    /////////////////
    Route::post('addReview', [ReviewsController::class, 'addReview']);
    Route::post('rate', [ReviewsController::class, 'rate']);

});
