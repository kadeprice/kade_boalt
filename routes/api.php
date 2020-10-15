<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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
/**Route for details user API */
Route::middleware('auth:api')->group(function(){

    Route::post('details', [ApiController::class, 'user_info']);
});