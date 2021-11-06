<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\auth\AuthController;
use App\Http\Controllers\Api\v1\SendInvitation;
use App\Http\Controllers\Api\v1\UserProfileController;

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
// Authentication API
Route::group([
    'prefix' => 'v1/auth'
], function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
   
});


Route::middleware('auth.role:admin,user')->post('v1/update-profile', [UserProfileController::class, 'update']);

// Invitation and Registration API
Route::group(['prefix' => 'v1/invite',
], function () {

    Route::post('send', [SendInvitation::class, 'send']);
    Route::post('register/{token}', [SendInvitation::class, 'register']);
    Route::post('verify/pin', [SendInvitation::class, 'verifyPin']);
});



// Invlaid Request Handle
Route::any('{any}', function () {
    return response()->json([
        'status'    => false,
        'message'   => 'Invalid Request. Please Write Correct API URL',
    ], 404);
})->where('any', '.*');
