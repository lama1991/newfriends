<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SliderController;
/*-------------------------------------------------------------------------
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
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/give-code',[AuthController::class,'giveCode'])->name('give.code');
Route::get('/logout',[AuthController::class,'logout']);


Route::get('/college/all',[CollegeController::class,'index'])->middleware(['auth:sanctum']);
Route::post('/college/create',[CollegeController::class,'store']);
Route::get('/college/{id}',[CollegeController::class,'show']);
Route::get('/specializations-of-college/{id}',[CollegeController::class,'specializationsof'])->middleware(['college','auth:sanctum']);

Route::get('/category/all',[CategoryController::class,'index']);
Route::post('/category/create',[CategoryController::class,'store']);
Route::get('/category/{id}',[CategoryController::class,'show']);
Route::get('/colleges-of-category/{id}',[CategoryController::class,'colleges']);

Route::post('/profile/update',[ProfileController::class,'update'])->name('profile.update');
Route::get('/profile/{user_uuid}',[ProfileController::class,'show'])->name('profile.show');
Route::get('/profile/all',[ProfileController::class,'index']);

Route::get('/slider/all',[SliderController::class,'index']);
Route::get('/slider/{id}',[SliderController::class,'show']);
Route::post('/slider/create',[SliderController::class,'store']);

Route::group(['middleware'=>['auth:sanctum']],function (){
    Route::post('/logout',[AuthController::class,'logout']);
});
