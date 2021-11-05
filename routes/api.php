<?php

use App\Http\Controllers\Api\AttachPostController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\FollowerController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\NewsFeedController;
use Illuminate\Support\Facades\Route;

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
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
});


// Page API
Route::group([
    'prefix' => 'page',
    'middleware' => 'auth:api'
], function () {

    Route::post('create', [PageController::class, 'create']);
    Route::post('{pageId}/attach-post', [AttachPostController::class, 'pagePost']);
});

// Follower  API
Route::group([
    'prefix' => 'follow',
    'middleware' => 'auth:api'
], function () {

    Route::post('person/{personId}', [FollowerController::class, 'followerByPerson'])->name('follow.person');
    Route::post('page/{pageId}', [FollowerController::class, 'followerByPage'])->name('follow.page');
});

// Attach   Post
Route::group([
    'prefix' => 'person',
    'middleware' => 'auth:api'
], function () {

    Route::post('attach-post', [AttachPostController::class, 'selfPost']);
    Route::get('feed', [NewsFeedController::class, 'getFeedData']);
});


// Invlaid Request Handle
Route::any('{any}', function () {
    return response()->json([
        'status'    => false,
        'message'   => 'Invalid Request. Please Write Correct API URL',
    ], 404);
})->where('any', '.*');
