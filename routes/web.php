<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdviceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OfferServiceController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceSpecialistController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SpecialistController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CategoryController ;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', [AuthController::class, "logindashboard"]);
Route::get('specialists' , [specialistController::class , 'index']); //show specialists
Route::get('/specialist/{id}',[specialistController::class , 'show']); // show specialist information

///
Route::get('categories' , [CategoryController::class , 'index']); //show specialists
Route::get('/category/{id}',[CategoryController::class , 'show']); // show specialist information
Route::get('addCategory',[CategoryController::class , 'store']); // show specialist information
Route::get('/editCategory/(id}',[CategoryController::class , 'update']); // show specialist information
Route::get('/deleteCategory/{id}',[CategoryController::class , 'destroy']); // show specialist information

//
Route::get('services' , [ServiceController::class , 'allservice']); //show specialists
Route::get('/service/{id}',[ServiceController::class , 'show']); // show specialist informationRoute::get('/editCategory/{id}', [CategoryController::class , 'update']);//edit specialist
Route::get('topServices' , [ServiceController::class , 'index']); //show specialists
Route::get('deleteService/{id}' , [ServiceController::class , 'destroy']); //show specialists
Route::post('addService' , [ServiceController::class , 'store']); //show specialists
Route::post('editService/{id}' , [ServiceController::class , 'update']); //show specialists
Route::get('Services/{id}' , [serviceController::class, "getCategoryDashboard"]) ; //services names for specific category


////
Route::get('offers' , [OfferController::class , 'index']); //show specialists
Route::get('soonOffers' , [OfferController::class , 'soon']); //show specialists
Route::get('addOffer' , [OfferController::class , 'store']); //show specialists
Route::get('editOffer/{id}'  , [OfferController::class , 'updateTypeZero']); //show specialists
Route::get('editSoonOffer/{id}'  , [OfferController::class , 'updateTypeOne']); //show specialists
Route::get('deleteOffer/{id}'  , [OfferController::class , 'destroyTypeZero']); //show specialists
Route::get('deleteSoonOffer/{id}'  , [OfferController::class , 'destroyTypeOne']); //show specialists
Route::get('offerDetails/{id}' , [OfferController::class , 'services']); //show specialists
Route::get('/offer-service/link', [OfferServiceController::class, 'store']);

///////////
Route::get('allmedia', [MediaController::class, 'index']); //show before & after
Route::get('upload', [MediaController::class, 'upload']);//upload before & after
Route::get('/editMedia/{id}', [MediaController::class, 'update']);
Route::get('/deleteMedia/{id}', [MediaController::class, 'destroy']);
Route::get('media/{id}', [MediaController::class, 'show']); //show before & after
///////////////////////
Route::get('/advice', [AdviceController::class, 'index']);
Route::post('/advice', [AdviceController::class, 'store']);
Route::get('/advice/{id}', [AdviceController::class, 'show']);
Route::put('/advice/{id}', [AdviceController::class, 'update']);
Route::delete('/advice/{id}', [AdviceController::class, 'destroy']);
/////////////////
Route::get('/approveSession/{id}', [SessionController::class, 'approveSession']);
Route::get('/refuseSession/{id}', [SessionController::class, 'refuseSession']);
Route::get('/completeSession/{id}', [SessionController::class, 'checkSession']);
Route::get('/pendingSessions', [SessionController::class, 'getPendingSessionsForAdmin']);
Route::get('/approvedSessions', [SessionController::class, 'getApprovedSessionsForAdmin']);
Route::get('/completedSessions', [SessionController::class, 'getCompletedSessionsForAdmin']);
Route::get('/refusedSessions', [SessionController::class, 'getRefusedSessionsForAdmin']);
///////////////////
Route::get('/reviews', [ReviewsController::class, 'index']);
Route::get('/users', [AuthController::class, 'allUsers']);
Route::get('/userDetails/{id}', [AuthController::class, 'userDetails']);
Route::get('/pendingReviews', [ReviewsController::class, 'getPendingReviews']);
Route::get('approveReview', [ReviewsController::class, 'approveReview']);
//Route::get('addSpecialist', [specialistController::class , 'store']);//edit specialist

Route::get('/link-service-specialist/{service_id}/{specialist_id}', [ServiceSpecialistController::class, 'linkServiceToSpecialist']);
Route::get('/unlink-service-specialist/{service_id}/{specialist_id}', [ServiceSpecialistController::class, 'unlinkServiceFromSpecialist']);



Route::middleware(['auth'])->group(function () {
    Route::get('addSpecialist', [specialistController::class , 'store']);//edit specialist
    Route::get('/deleteSpecialist/{id}',[specialistController::class,'destroy']);// delete specialist
    Route::get('/editSpecialist/{id}', [specialistController::class , 'update']);//edit specialist

});



















