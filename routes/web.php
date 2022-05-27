<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\CarController;
use \App\Http\Controllers\User\UserController;
use \App\Http\Controllers\User\SellCarController;
use \App\Http\Controllers\User\AuctionClaimController;
use \App\Http\Controllers\User\AuctionCarController;

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

///////////////////// CarController Route Start /////////////////////
Route::get('/getCars', [CarController::class, 'GetCars']);
Route::get('/getUserCars', [CarController::class, 'GetUserCars']);
Route::post('/insertCar', [CarController::class, 'InsertCar']);
Route::get('/deleteCar/{carid}', [CarController::class, 'DeleteCar'])->where('carid', '[0-9]+');
Route::get('/editCar/{carid}', [CarController::class, 'EditCar'])->where('carid', '[0-9]+');
Route::post('/updateCar', [CarController::class, 'UpdateCar']);
Route::post('/activeCar', [CarController::class, 'ActiveCar']);
///////////////////// CarController Route End /////////////////////

///////////////////// AuctionCarController Route Start /////////////////////
Route::post('/joinToAuction', [AuctionCarController::class, 'JoinToAuction']);
Route::post('/auctionBid', [AuctionCarController::class, 'AuctionBid']);
Route::post('/getCurrentAuctionBid', [AuctionCarController::class, 'GetCurrentAuctionBid']);
///////////////////// AuctionCarController Route End /////////////////////

///////////////////// AuctionClaimController Route Start /////////////////////
Route::post('/setAuctionClaim', [AuctionClaimController::class, 'SetAuctionClaim']);
///////////////////// AuctionClaimController Route End /////////////////////

///////////////////// SellCarController Route Start /////////////////////
Route::post('/buyerSendRequestToSeller', [SellCarController::class, 'BuyerSendRequestToSeller']);
Route::post('/sellerGetRequests', [SellCarController::class, 'SellerGetRequests']);
///////////////////// SellCarController Route End /////////////////////

///////////////////// UserController Route Start /////////////////////
Route::post('/userLogin', [UserController::class, 'UserLogin']);
Route::get('/userLogout', [UserController::class, 'UserLogout']);
Route::post('/userAccountRegister', [UserController::class, 'UserAccountRegister']);
Route::get('/createConfirmPhoneNumber/{userid}', [UserController::class, 'CreateConfirmPhoneNumber'])->where('userid', '[0-9]+');
Route::get('/createConfirmEmail/{userid}', [UserController::class, 'CreateConfirmEmail'])->where('userid', '[0-9]+');
Route::post('/checkConfirmCode', [UserController::class, 'CheckConfirmCode']);
Route::post('/userPaymentForUpgrade', [UserController::class, 'UserPaymentForUpgrade']);
///////////////////// UserController Route End /////////////////////
