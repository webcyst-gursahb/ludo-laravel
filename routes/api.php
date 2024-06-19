<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register','usersController@register');
Route::post('login','usersController@login');
Route::post('userBalance','usersController@getUserBal');
Route::get('packages','PackageController@packages');

Route::post("activatePackage","PackageController@activatePackage");
Route::post("balance_transfer","usersController@bal_transfer");
Route::post("updateProfile","usersController@updateProfile");
Route::post("walletSummary","usersController@walletSummary");
Route::post("getDownline","usersController@getDownline");
Route::post("levelIncome","usersController@levelIncome");

Route::post("withdrawAmount","WithdrawController@store");
Route::post("getIncomeBalance","usersController@getIncomeBal");
// Route::post("getTotalIncomeBalance","usersController@getTotalIncomeBal");
// Route::post('totalUserBalance','usersController@totalUserBal');
Route::post('getUserDetails','usersController@getUserDetails');
Route::post('withdrawMainBalance','usersController@withdrawMain');
Route::post('generationIncome','usersController@generationIncome');
Route::post('generationIncomeDetails','usersController@generationIncomeDetails');
Route::post('getUserDirect','usersController@userDirect');
Route::post('userDirectDetails','usersController@userDirectDetails');

Route::post('totalBalance','usersController@getTotalBal');
Route::post('mainWithdrawDetails','usersController@withdrawDetails');
Route::post('getUserName','usersController@getUserName');

Route::post("bindApi","usersController@bindApi");
Route::post("bedsDetails","BinanceController@bedsDetails");
Route::post("bedsRecords","BinanceController@bedsRecords");
Route::post("openOrders","BinanceController@openOrders");
Route::post("qrcode","BinanceController@getQrCode");

Route::post('profitIncome','usersController@profitIncome');
Route::post('profitIncomeDetails','usersController@profitIncomeDetails');

Route::post('totalDirects','usersController@totalDirects');
Route::post('totalActiveDirects','usersController@totalActiveDirects');
Route::post('totalTeam','usersController@totalTeam');
Route::post('totalActiveTeam','usersController@totalActiveTeam');

Route::post("directReferrals","usersController@directReferral");
Route::post("directReferralDetails","usersController@directReferralDetails");


Route::post("forgotPassword","usersController@forgotPwd");
Route::post("confirmOTP","usersController@checkOTP");
Route::post("updatePassword","usersController@updatePwd");

Route::post("updatePassword","usersController@updatePwd");
Route::post("orderDetails","usersController@orderDetails");

Route::post("ipn_url","BinanceController@ipn_url");
Route::post("paymentStatus","BinanceController@payment_status");

Route::post("userAmount","usersController@user_amount");

Route::post("coinPrices","BinanceController@coinPrices");

Route::post("binanceBalance","usersController@binanceBal");

Route::post("verifyEmail","usersController@verifyEmail");
Route::post("resendEmail",'usersController@resendEmail');

Route::post("updateAddress",'usersController@updateWithdrawalAddress');
Route::post("MainToFuel",'usersController@MainToFuel');
Route::post('payment','usersController@payment');

Route::post('level_bonus','usersController@getLevelBonus');
Route::post('total_team','usersController@getTotalTeam');
Route::post('total_directs','usersController@getTotalDirects');
Route::post('total_withdraw','usersController@getTotalWithdraw');
Route::post('details','usersController@details');

Route::get('getVideoUrl','usersController@getVideoUrl');
Route::get('getAppVersion','usersController@appVersion');
Route::post('link','usersController@link');
Route::post('activationDetails','usersController@activationDetails');
Route::post('fundHistory','usersController@fundHistory');

Route::post('socialLinks','usersController@socialLinks');
Route::post('getName','usersController@getName');
Route::post('updateImage','usersController@updateImg');

Route::get('game_packages','usersController@gamePackages');
Route::post('gameLevelIncome','usersController@gameLevelIncome');
Route::post('gameWinDetails','usersController@gameWinDetails');
Route::post('gameLoseDetails','usersController@gameLoseDetails');
Route::get('gameTestPackages','usersController@gameTestPackages');

Route::post('verfiyDevice','usersController@verfiyDevice');
Route::post('gameRecords','usersController@gameRecords');

Route::post("test",'usersController@test');
