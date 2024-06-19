<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('login');
});
Route::get('/admin', function () {
    return redirect('login');
});

Auth::routes();
Route::get("getPrice","BinanceController@getPrice")->name('getPrice');
Route::get("referralLink",'usersController@referralLink');
Route::get("openLink",function(){
    return view('admin.openLink');
});


Route::get("/chat",function(){
    return view("chat");
});

Route::middleware(["auth","is_admin"])->prefix("admin")->group(function(){
    //all users
    Route::get("home",'usersController@index')->name("admin.home");
    Route::get("users",'usersController@users')->name("admin.users");
    Route::get("activeUsers",'usersController@activeUsers')->name("admin.activeUsers");

    Route::get("editUser/{id}",'usersController@editUser')->name("admin.editUser");
    Route::post("updateUser/{id}",'usersController@updateUser')->name("admin.updateUser");
    
    //sponsers
    Route::get("sponsers",'usersController@sponsers')->name("admin.sponsers");

    //user wallet transactions
    Route::get("transactions",'usersController@transactions')->name("admin.transactions");
    Route::get("sendBal/{id}",'usersController@sendBal')->name("admin.sendBal");
    Route::get("sendEpin/{id}",'usersController@sendEpin')->name("admin.sendEpin");
    Route::post("postEpin/{id}",'usersController@postEpin')->name("admin.postEpin");
    Route::post("postBal/{id}",'usersController@postBal')->name("admin.postBal");

    //packages
    Route::get("packages","PackageController@index")->name("admin.packages");
    Route::get("addPackage","PackageController@add")->name("admin.addPackage");
    Route::post("storePackage","PackageController@store")->name("admin.storePackage");
    Route::get("editPackage/{id}","PackageController@edit")->name("admin.editPackage");
    Route::post("updatePackage/{id}","PackageController@update")->name("admin.updatePackage");
    Route::get("deletePackage/{id}","PackageController@delete")->name("admin.deletePackage");

    //game packages
    Route::get("game_packages","PackageController@gameIndex")->name("admin.gamePackages");
    Route::get("addGamePackage","PackageController@gameAdd")->name("admin.addGamePackage");
    Route::post("storeGamePackage","PackageController@gameStore")->name("admin.storeGamePackage");
    Route::get("editGamePackage/{id}","PackageController@gameEdit")->name("admin.editGamePackage");
    Route::post("updateGamePackage/{id}","PackageController@gameUpdate")->name("admin.updateGamePackage");
    Route::get("deleteGamePackage/{id}","PackageController@gameDelete")->name("admin.deleteGamePackage");

    //wallet details
    Route::get("fuelWallet","usersController@fuelWallet")->name("admin.fuelWallet"); 
    Route::get("incomeWallet","usersController@incomeWallet")->name("admin.incomeWallet"); 


    //withdraws
    Route::get("withdrawDetails","WithdrawController@index")->name("admin.withdraws");
    Route::get("withdrawRequest","WithdrawController@request")->name("admin.withdrawRequest");
    Route::post("withdrawAccept","WithdrawController@acceptRequest")->name("withdraw.accept");
    Route::post("withdrawReject","WithdrawController@rejectRequest")->name("withdraw.reject");

    //binance
    Route::get("binance",'BinanceController@index')->name("admin.binance");
    Route::get("placeBet",'BinanceController@binance')->name("admin.binanceBet");
    Route::get("sellCoin",'BinanceController@sellCoin')->name("admin.sellCoin");
    Route::post("postSell",'BinanceController@postSell')->name("admin.postSell");
    Route::get("allCoins","BinanceController@allCoins")->name("admin.allCoins");
    // Route::get("sendCoin","BinanceController@sendCoin")->name("admin.sendCoin");
    Route::post("placeBet","BinanceController@submitBet")->name("admin.submitBet");
    Route::get("binanceBalance","BinanceController@binanceBal")->name("admin.binanceBal");
    Route::get("binanceHistory","BinanceController@binanceHistory")->name("admin.binanceHistory");

    //add api key and secret key for admin
    Route::get("addApi",'usersController@addApi')->name("admin.addApi");
    Route::post("storeApi",'usersController@updateApi')->name("admin.storeApi");

    Route::get("/allCoins","BinanceController@coins")->name("binance.allCoins");
    Route::get("/editCoin/{id}","BinanceController@editCoin")->name("binance.editCoin");
    Route::post("/updateCoin/{id}","BinanceController@updateCoin")->name("binance.updateCoin");

    //remove sell
    Route::post("/removeSell","BinanceController@removeSell")->name("admin.removeSell");
    Route::post("/removeBid","BinanceController@removeBid")->name("admin.removeBid");

    //binance Details(History)
    Route::get("/binanceDetails","BinanceController@binanceDetails")->name("binance.details");

    Route::post("acceptPay","AdminController@accept")->name('admin.accept');
    Route::post("rejectPay","AdminController@reject")->name('admin.reject');

    Route::get("pendingPayments","AdminController@index")->name('admin.pendingPayments');
    Route::get("completedPayments","AdminController@completedPayments")->name('admin.completedPayments');
    Route::get("rejectedPayments","AdminController@rejectedPayments")->name('admin.rejectedPayments');
    Route::get("changePassword","AdminController@changePassword")->name('admin.changePassword');

    Route::get("changeProfile","AdminController@changeProfile")->name('admin.changeProfile');
    Route::post("updateProfile","AdminController@updateProfile")->name('admin.updateProfile');
    Route::post("activateUser/{id}","AdminController@activateUser")->name('admin.activate');

});
