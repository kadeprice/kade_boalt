<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SpotifyController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




/**Route for register API */
Route::post('register', [ApiController::class, 'register']);
/**Route for login API */
Route::post('login', [ApiController::class, 'login']);

/**** Protected Routes ****/
Route::middleware('auth:api')->group(function () {
    //Return user details
    Route::post('details', [ApiController::class, 'user_info']);

    /***** Notification Routes ******/
    Route::post('create-notification', [NotificationController::class, 'store']);
    Route::post('unread-notification', [NotificationController::class, 'showUnread']);
    Route::post('all-notification', [NotificationController::class, 'showAll']);
    Route::post('mark-notification-read', [NotificationController::class, 'markRead']);
    Route::post('mark-notification-unread', [NotificationController::class, 'markUnread']);

    /***** Spotify Routes ********/
    Route::post('spotify-tracks', [SpotifyController::class, 'searchTracks']);
    Route::post('spotify-artists', [SpotifyController::class, 'searchArtists']);
});