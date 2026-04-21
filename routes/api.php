<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminTechnicianDetailController;
use App\Http\Controllers\AdminRequestController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\AdminRegionController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NotificationTokenController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TechnicianDetailController;
use App\Http\Controllers\TechnicianRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RequestAdditionController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\TestFirebaseNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    // Profile
    Route::get('profile',  [UserController::class, 'profile']);
    Route::patch('profile', [UserController::class, 'updateProfile']);
    Route::patch('profile/password', [UserController::class, 'updatePassword']);
});



//for Tenant
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('requests', RequestController::class);
});
   Route::middleware(['auth:sanctum', 'role:tenant']) 
   ->prefix('tenant/requests')
   ->group(function () {
    Route::patch('{id}/confirm-estimate', [RequestController::class, 'confirmEstimate']);
    Route::patch('{id}/reject-estimate', [RequestController::class, 'rejectEstimate']);
    Route::patch('{id}/approve-final-price', [RequestController::class, 'approveFinalPrice']);
    Route::patch('{id}/reject-final-price', [RequestController::class, 'rejectFinalPrice']);
});




//for Technician
Route::middleware(['auth:sanctum','role:technician'])->group(function () {
    Route::get ('/technician-details', [TechnicianDetailController::class, 'index']);
    Route::patch('/technician-details', [TechnicianDetailController::class, 'update']);
});

    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/regions',  [RegionController::class, 'index']);




    Route::middleware(['auth:sanctum', 'role:technician'])
    ->prefix('technician/requests')
    ->group(function () {
        Route::get('/available', [TechnicianRequestController::class, 'availableRequests']);
        Route::get('{id}', [TechnicianRequestController::class, 'showAssignedRequest']);

        Route::patch('{id}/send-estimate', [TechnicianRequestController::class, 'sendEstimate']);
        Route::patch('{id}/start-processing', [TechnicianRequestController::class, 'startProcessing']);
        Route::patch('{id}/request-final-approval', [TechnicianRequestController::class, 'requestFinalApproval']);
        Route::patch('{id}/submit-final-price', [TechnicianRequestController::class, 'submitFinalPrice']);

        Route::get('{requestId}/additions', [RequestAdditionController::class, 'index']);
        Route::post('{requestId}/additions', [RequestAdditionController::class, 'store']);
        Route::delete('{requestId}/additions/{additionId}', [RequestAdditionController::class, 'destroy']);
       
        //  قائمة طلبات الفني الحالية
        // Route::get('', [TechnicianRequestController::class, 'index']);
    });


    Route::middleware('auth:sanctum')->group(function () {
    // قائمة صور الطلب
    Route::get('/requests/{id}/media', [MediaController::class, 'index']);
    // رفع صورة (قبل/بعد)
    Route::post('/requests/{id}/media', [MediaController::class, 'store']);
    // حذف صورة
    Route::delete('/media/{id}', [MediaController::class, 'destroy']);
});


//Admin

Route::middleware(['auth:sanctum','role:admin'])
    ->prefix('admin')
    ->group(function () {
        //Technician_detail
        Route::get   ('/technician-details',        [AdminTechnicianDetailController::class, 'index']);
        Route::post  ('/technician-details',        [AdminTechnicianDetailController::class, 'store']);
        Route::get   ('/technician-details/{id}',   [AdminTechnicianDetailController::class, 'show']);
        Route::patch ('/technician-details/{id}',   [AdminTechnicianDetailController::class, 'update']);
        Route::delete('/technician-details/{id}',   [AdminTechnicianDetailController::class, 'destroy']); 

        // Requests
        Route::get   ('/requests',        [AdminRequestController::class, 'index']);
        Route::get   ('/requests/{id}',   [AdminRequestController::class, 'show']);
        Route::patch ('/requests/{id}',   [AdminRequestController::class, 'update']);

        // Services
        Route::get   ('/services',        [AdminServiceController::class, 'index']);
        Route::post  ('/services',        [AdminServiceController::class, 'store']);
        Route::get   ('/services/{id}',   [AdminServiceController::class, 'show']);
        Route::patch ('/services/{id}',   [AdminServiceController::class, 'update']);
        Route::delete('/services/{id}',   [AdminServiceController::class, 'destroy']);

        // Regions
        Route::get   ('/regions',         [AdminRegionController::class, 'index']);
        Route::post  ('/regions',         [AdminRegionController::class, 'store']);
        Route::get   ('/regions/{id}',    [AdminRegionController::class, 'show']);
        Route::patch ('/regions/{id}',    [AdminRegionController::class, 'update']);
        Route::delete('/regions/{id}',    [AdminRegionController::class, 'destroy']);
    });
    Route::middleware('auth:sanctum')->group(function () {
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::get('/addresses/{id}', [AddressController::class, 'show']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::put('/addresses/{id}', [AddressController::class, 'update']);
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);

});

    

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('requests/{id}/pay', [PaymentController::class, 'pay']);
    });

    // webhook بدون auth
    
// webhook بدون auth
    Route::post('stripe/webhook', [StripeWebhookController::class, 'handle']);

    //Notification
    Route::middleware('auth:sanctum')->post('/save-fcm-token', [NotificationTokenController::class, 'store']);
    //test
    Route::middleware('auth:sanctum')->post('/test-firebase-notification', [TestFirebaseNotificationController::class, 'send']);



