<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\bid;
use App\user_bid_details;
use App\bid_log;
use App\wallet;
use App\order;
use App\callback;
use App\coin;
use App\price;
use Binance\API;
use Laravel\Ui\Presets\React;
use Prophecy\Call\Call;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Mockery\Undefined;

class BinanceController extends Controller
{

    // public function index(){

    //     $users = User::where("api_key","!=","")->where("secret_key","!=","")->where("is_admin","!=",1)->orderBy("id","desc")->paginate();
    //     $users->map(function($data){
    //         $credit = wallet::where("user_id",$data->id)->where("wallet_type","F")->where("status",0)->sum("amount");
    //         $debit = wallet::where("user_id",$data->id)->where("wallet_type","F")->where("status",1)->sum("amount");
    //         $balance = $credit-$debit;
    //         $api = new API($data->api_key,$data->secret_key);
    //         $api->useServerTime();
    //         $ticker = $api->prices();
    //         $balances = $api->balances($ticker);
    //         $bal = $balances['USDT']['available'];
    //         $data->bal_usdt = $bal;
    //         $data->balance = $balance;
    //         return $data;
    //     });
    //     return view("admin.binance",compact("users"));
    // }

    // public function allCoins(){
    //     return view("admin.allCoins");
    // }

    // public function binance(Request $request){
      
    //     if(!$request->users){
    //         return redirect()->back()->with("error","Please Select at least one user for bets");
    //         exit;
    //     }
    //     // $users = User::whereIn("id",$request->users)->get();
    //     // $api = new API($users[0]->api_key,$users[0]->secret_key,true);
    //     $user = User::where("is_admin",1)->first();
    //     $api = new API($user->api_key,$user->secret_key);
    //     // $api->useServerTime();
    //     $ticker = $api->prices();
    //     $balances = $api->balances($ticker);
    //     $coins = [];
    //     $prices = [];
    //     $coins1= [];
    //     if($request->search){
    //         if(array_key_exists($request->search,$ticker)){
    //             $ticker = $ticker;
    //         }
    //     }
    //     foreach($ticker as $key=>$val){
    //         if(preg_match("/usdt/i",$key)){
    //             $coin =coin::where("name",$key)->first();
    //             if(empty($coin)){
    //                 coin::create([
    //                     "name"=>$key,
    //                     "coin_name"=>substr($key,"0","-4")
    //                 ]);
    //             }
    //             if($coin->value != -1){
    //                 $coins1[] = $coin->coin_name;
    //                 $prices[] = $val;
    //             }
    //             // $coins1[] = $key;
    //             // $prices[] = $val;

    //         }
    //     }
    //     foreach($balances as $key=>$bal){
    //         $coins[] = $key;
    //     }
        
    //     $coinprices = array_combine($coins1,$prices);
        
    //     $users = $request->users;
    //     $bid_details = bid::where("type","buy")->orderBy("id","desc")->take(5)->get();
    //     return view("admin.allCoins",["coins"=>$coins,'users'=>$users,"coinprices"=>$coinprices,"bids"=>$bid_details]);



    // //   foreach($users as $user){
    // //     $api = new API($user->api_key,$user->secret_key,true);
    // //     $api->useServerTime();
    // //     $ticker = $api->prices();
    // //     $balances = $api->balances($ticker);
    // //     print_r($balances);

    // //   }

    //   die;
    //     // $api = new API("SwVX61D3qsE7HlE0dcg2UpMKEqSkrcyvrgh8UYa78d78L5RxK4IlQAKtft30jlu7","tiu6LSQ1qjrQKLYVtCoGpEM7iF2wd8lNIkSojTFfT6g0rAjF8zejuMWfK5v0d3iO");
    //     // $user = User::where("api_key","!=","")->where("secret_key","!=","")->get();
    //     $user = User::where("id",$request->id)->first();
    //     if(empty($user)){
    //         return response()->json(["status"=>0]);
    //     }

    //     $api = new API($user->api_key,$user->secret_key,true);

    //     // echo $api;
    //     $api->useServerTime();
    //     $ticker = $api->prices(); // Make sure you have an updated ticker object for this to work
    //     // $exchangeInfo = $api->exchangeInfo();
    //     // print_r($exchangeInfo);
    //     $balances = $api->balances($ticker);
        
      
    //     // print_r($coins);
    //     // print_r($balances);
    //     // print_r("USDT".$balances['USDT']['available'].PHP_EOL); 
    //     // print_r("BUSDT".$balances['BUSD']['available'].PHP_EOL); 



    //     // $price = $api->price("BNBUSDT");
    //     // echo $price;
        
    //     // echo "BTC owned: ".$balances['BTC']['available'].PHP_EOL;
    //     // echo "ETH owned: ".$balances['ETH']['available'].PHP_EOL;
    //     // echo "Estimated Value: ".$api->btc_value." BTC".PHP_EOL;
        
        
    //     // $quantity = 1;
    //     // $order = $api->marketBuy("ETHBTC", $quantity);


    //     // $history = $api->history("BNBBTC");
    //     // print_r($history);
    //     // $quantity = 500;
    //     // $order = $api->marketBuy("TRXUSDT", $quantity);
        
    //     // $quantity = 1;
    //     // $price = 100;
    //     // $order = $api->buy("TRXUSDT", $quantity, $price);
    //     // print_r($order);
    // }


    // // public function SendCoin(Request $request){
        
    // //     $users = User::whereIn("id",$request->users)->get();
    // //     $api = new API($users[0]->api_key,$users[0]->secret_key,true);
    // //     $api->useServerTime();
    // //     // $history = $api->history("TRXUSDT");
    // //     // dd($history);
    // //     $ticker = $api->prices();
    // //     $balances = $api->balances($ticker);
    // //     $coins = [];
    // //     foreach($balances as $key=>$bal){
    // //             $coins[] = $key;
    // //         }

    // //     $users = $request->users;
    // //     $coin = $request->coin;
    // //     if(!$users || !$coins || !$coin){
    // //         return redirect()->back()->with("error","Please Select at least one coin for place bid");
    // //         exit;
    // //     }
    // //     return view("admin.finalBet",compact('coins','users','coin'));
    // // }

    // public function submitBet(Request $request){
    //     $this->validate($request,[
    //         "per"=>"numeric|min:10"
    //     ]);
    //     $per = $request->per;
    //     if(!$per && empty($per)){
    //         return redirect()->back()->with("error","Please Select Valid Percentage");
    //         exit;
    //     }
    //     if(!$request->users && !$request->to_coin && $request->from_coin){
    //         return redirect()->back()->with("error","Please select valid coin");
    //         exit;
    //     }

    //     $users = User::whereIn("id",$request->users)->get();

    //     $api = new API($users[0]->api_key,$users[0]->secret_key);
    //     $api->useServerTime();
    //     $from_coin = $request->from_coin;
    //     $to_coin = $request->to_coin;
    //     // dd("from_coin ".$from_coin." to_coin ".$to_coin);
    //     $to_coin_price = $api->price($to_coin."USDT");
    //         $type = "buy";

    //         $ticker = $api->prices();
    //         $balances = $api->balances($ticker);
    //         $balance = $balances[$from_coin]['available'];
    //         $quantity = ($per*$balance)/100;

    //         $price =  $api->price($to_coin.$from_coin);
    //         // echo $quantity;
    //         // echo "<br>";
            
    //         // $token = User::where("is_admin",1)->first();
    //         // include app_path().'/Http/Controllers/init.php';
    //         // $coin->Setup($token->private_key,$token->public_key);
    //         // $rates = $coin->GetRates();
    //         // $fiat_price = $quantity;
    //         // $fiat_to_btc = $rates['result']['USDT']['rate_btc'];
    //         // $price_in_btc = ($fiat_price * $fiat_to_btc);
    //         // $this_currency_rate_btc = $rates['result'][$to_coin]['rate_btc'];
    //         // $quan = ($price_in_btc/$this_currency_rate_btc);
    //         // $quan = $quantity/$price;
    //         // $quan = number_format((float)$quan, 1, '.', '');
    //         // echo "Usdt ".$quantity;
    //         // echo "<br>";
    //         // echo "Gmt ".$quan;
                    
    //         $coin = coin::where("coin_name",$to_coin)->first();
    //         $value = $coin->value;
           
    //     $bid = bid::create([
    //         "from_coin_price"=>$to_coin_price,
    //         "type"=>$type,
    //         "to_coin_price"=>1,
    //         "from_coin"=>$from_coin,
    //         "to_coin"=>$to_coin,
    //     ]);
        
    //     $bidId = $bid->id;
    //     $error_logs = [];
    //     $logs = [];
    //       foreach($users as $user){
            
    //         $userId = $user->id;
    //         $usr = User::where("id",$userId)->first();
    //         if(empty($usr)){
    //             $log = new bid_log();
    //             $log->user_id=$usr->id;
    //             $log->bid_id=$bidId;
    //             $log->description="Bid not placed due to invalid user id=".$usr->id;
    //             $log->save();
    //             $error_logs[] = $log;
    //             bid::where("id",$bidId)->delete();
    //             continue;
    //             exit;
    //         }

    //         $credit = wallet::where("wallet_type","F")->where("user_id",$userId)->where("status",0)->sum('amount');
    //         $debit = wallet::where("wallet_type","F")->where("user_id",$userId)->where("status",1)->sum('amount');
    //         $fuel_balance = $credit - $debit;

    //         if($fuel_balance < 15){
    //             $log = new bid_log();
    //             $log->user_id=$usr->id;
    //             $log->bid_id=$bidId;
    //             $log->description="Bid not placed due to low fuel balance of user id=".$usr->id;
    //             $log->save();
    //             $error_logs[] = $log;
    //             bid::where("id",$bidId)->delete();
    //             continue;
    //             exit;
    //         }

    //         $api = new API($user->api_key,$user->secret_key);
    //         $api->useServerTime();
    //         $ticker = $api->prices();
    //         $balances = $api->balances($ticker);
    //         $balance = $balances[$from_coin]['available'];
    //         $to_bal = $balances[$to_coin]['available'];
            
    //         $quantity =$per*$balance/100;
    //         if($quantity < 0 || $balance < 1){
    //             return redirect()->back()->with("error","Insufficient Balance");
    //         }
    //         // $per = (0.05/100)*$quantity;
    //         // $finalq = $quantity-$per;
    //         // $finalq = number_format((float)$finalq, 2, '.', '');
    //         // $quantity= number_format((float)$quantity, 1, '.', '');


    //         // $price =  $api->price($to_coin.$from_coin);
    //         // $quan = $quantity;
    //         // if($to_coin != "TRX"){
    //             // $quan = $quantity/$price;
    //             // $quan = number_format((float)$quan, 2, '.', '');
    //         // }
    //         $price =  $api->price($to_coin.$from_coin);

    //         $quan = $quantity/$price;

    //         $feecm = (0.25/100)*$quan;
    //         $quan = $quan-$feecm;
            

    //         // echo floor(2.56789 * 10) / 10;
    //         // echo floor($quan*100)/100;
            
    //         // ;
    //         // echo $quan;
       
    //             $quan = bcdiv($quan, 1 ,$value);
              
            
    //         // $token = User::where("is_admin",1)->first();
    //         // include app_path().'/Http/Controllers/init.php';
    //         // $coin->Setup($token->private_key,$token->public_key);
    //         // $rates = $coin->GetRates();
    //         // $fiat_price = $quantity;
    //         // $fiat_to_btc = $rates['result']['USDT']['rate_btc'];
    //         // $price_in_btc = ($fiat_price * $fiat_to_btc);
    //         // $this_currency_rate_btc = $rates['result'][$to_coin]['rate_btc'];
    //         // $quan = $price_in_btc/$this_currency_rate_btc;

    //         if($balance < $quantity){
    //             $log = new bid_log();
    //                 $log->user_id=$userId;
    //                 $log->bid_id=$bidId;
    //                 $log->description="bid not placed due to low balance of user ".$user->email." quantity ".$quantity;
    //                 $log->save();
    //                 $error_logs[] = $log;
    //             bid::where("id",$bidId)->delete();
    //             continue;
    //             exit;
    //         }

    //         $order = $api->marketBuy($to_coin.$from_coin,$quan);

    //         $from_coin_quantity = $order['cummulativeQuoteQty'];
    //         $to_coin_quantity = $order['executedQty'];
    //         $ordr = json_encode($order);

    //         bid_log::create([
    //             "bid_id"=>$bidId,
    //             "user_id"=>$userId,
    //             "description"=>$ordr
    //         ]);

    //         user_bid_details::create([
    //             "user_id" => $userId,
    //             "bid_id"=>$bidId,
    //             "from_coin"=>$from_coin,
    //             "to_coin"=>$to_coin,
    //             "from_coin_quantity"=>$from_coin_quantity,
    //             "to_coin_quantity"=>$to_coin_quantity,
    //             "status_type"=>"buy",
    //             "cummulativeQuoteQty"=>$order['cummulativeQuoteQty'],
    //             "executedQty"=>$order['executedQty'],
    //         ]);
    //         $log = new bid_log();
    //         $log->user_id = $userId;
    //         $log->bid_id = $bidId;
    //         $log->description="coin are ".$type." from_coin ".$from_coin." to coin ".$to_coin." of user ".$user->email." quantity ".$quantity;
    //         $log->save();
    //         $logs[]=$log;
    //     }

    //     // $logs = bid_log::where("bid_id",$bidId)->get();
    //     // $ud = user_bid_details::where("bid_id",$bidId)->first();
    //     // if(empty($ud)){
    //     //     bid::where("id",$bidId)->delete();
    //     // }

        
    //     return redirect()->back()->with(["logs"=>$logs,"error_logs"=>$error_logs]);
    // }
    
    // public function truncate_number( $number, $precision = 2) {
    //     // Zero causes issues, and no need to truncate
    //     if ( 0 == (int)$number ) {
    //         return $number;
    //     }
    //     // Are we negative?
    //     $negative = $number / abs($number);
    //     // Cast the number to a positive to solve rounding
    //     $number = abs($number);
    //     // Calculate precision number for dividing / multiplying
    //     $precision = pow(10, $precision);
    //     // Run the math, re-applying the negative value to ensure returns correctly negative / positive
        
    //     $res = floor( $number*$precision ) / $precision * $negative;
    //     return $res;
    // }
    // public function binanceBal(Request $request){
    //     $user = User::where("id",$request->id)->first();
    //     $api = new API($user->api_key,$user->secret_key);
    //     $api->useServerTime();
    //     $ticker = $api->prices();
    //     $balances = $api->balances($ticker);
    //     $coins = [];
    //     $prices = [];
    //     $balance = [];
    //     foreach($balances as $key=>$bal){
    //         $coins[] = $key;
    //         $balance[] = $bal['available'];
    //     }
    //     $coins = array_combine($coins,$balance);
    //     return view("admin.binanceBal",compact('coins','user'));

    // }

    // public function binanceHistory(Request $request){
    //     $bids = bid::join("user_bid_details","bids.id","user_bid_details.bid_id")->where("bids.id",$request->id)->orderBy("bids.id","desc")->paginate();$bids->appends(["user_id"=>$request->user_id]);
    //     $bids->appends(["id"=>$request->id]);
    //     if($request->user_id){
    //         $bids = bid::join("user_bid_details","bids.id","user_bid_details.bid_id")->where("user_bid_details.user_id",$request->user_id)->orderBy("bids.id","desc")->paginate();
    //         $bids->appends(["user_id"=>$request->user_id]);
    //     }
    //     $bids->map(function($data){
    //         $data->user = User::where("id",$data->user_id)->first();
    //         return $data;
    //     });

    //     return view("admin.binanceHistory",compact('bids'));
    // }

    // public function sellCoin(Request $request){
    //     $bids = bid::join("user_bid_details","bids.id","user_bid_details.bid_id")->where("bids.status",0)->orderBy("bids.id","desc")->groupBy("bid_id")->get();
    //     $sells = bid::orderBy("id","desc")->where("sell_from_coin","!=","")->paginate(5);
    //     $bid_details = user_bid_details::whereIn("bid_id",$sells)->get();
      
    //     $bids->map(function($data){
    //         $user = User::where("is_admin",1)->first();
    //         $api = new API($user->api_key,$user->secret_key);
    //         $api->useServerTime();
    //         $data->current_price = $api->price($data->to_coin.'USDT');
    //         return $data;
    //     });
    //     $i=0;
    //     $beds= [];
    //     foreach($bids as $bid){
    //         $beds[$i] =$bid;
    //         $users = user_bid_details::where("bid_id",$bid->bid_id)->where("sell_status",0)->where("status_type",'buy')->get();
    //         $beds[$i]['users'] = $users;
    //         $i++;
    //     }

      
        
    //     $total = count($beds);
    //     $per_page = 15;

    //     $current_page = $request->input("page") ?? 1;
    //     $starting_point = ($current_page * $per_page) - $per_page;
    //     $beds = array_slice($beds, $starting_point, $per_page, true);
    //     $beds = new Paginator($beds, $total, $per_page, $current_page, [
    //         'path' => $request->url(),
    //         'query' => $request->query(),
    //     ]);

    //     $user = User::where("is_admin",1)->first();
    //     $api = new API($user->api_key,$user->secret_key);
    //     $api->useServerTime();
    //     $ticker = $api->prices();
    //     $balances = $api->balances($ticker);
    
    //     if($bid_details->count() == 0){
    //         $sells = "";
    //     }
    //     return view("admin.sellCoin",compact('beds','sells'));
    // }

    // public function postSell(Request $request){
    //     $from_coin = $request->from_coin;
    //     $to_coin = $request->to_coin;
    //     $users=  $request->users;
    //     $buy_rate = $request->buy_price;
    //     $type = "sell";
    //     $logs = [];
        
    //     $user  = User::where("id",$users[0])->first();
    //     $api = new API($user->api_key,$user->secret_key);
    //     $api->useServerTime();
    //     $ticker = $api->prices();
    //     $balances = $api->balances($ticker);
    //     $from_coin_price = $api->price($from_coin."USDT");

    //     $bidId = $request->bid_id;
    //     bid::where("id",$bidId)->update([
    //         "sell_from_coin_price"=>1,
    //         "sell_to_coin_price"=>$from_coin_price,
    //         "sell_from_coin"=>$from_coin,
    //         "sell_to_coin"=>$to_coin,
    //         "open_rate"=>$buy_rate,
    //         "close_rate"=>$from_coin_price
    //     ]);
    //         // if($balance < $request->quantity){
    //         //         $log = new bid_log();
    //         //         $log->user_id=$user->id;
    //         //         $log->bid_id=$bidId;
    //         //         $log->description="bid not placed due to low balance";
    //         //         $log->save();
    //         //     $logs[] = $log;
    //         //     return redirect()->back()->with(["log"=>$logs,"error"=>""]);
    //         // }
            
    //     $prev_quantity = $request->prev_quantity;
    //     foreach($users as $user){
    //         $userr = User::where("id",$user)->first();
    //         $api = new API($userr->api_key,$userr->secret_key);
    //         $api->useServerTime();
    //         // $ticker = $api->prices();
    //         // $balances = $api->balances($ticker);
    //         // $quantity = $balances[$from_coin]['available'];
    //         $userId = $user;
    //         $user_bid = user_bid_details::where("user_id",$userId)->where("bid_id",$request->bid_id)->first();
    //         $quantity = $user_bid->executedQty;
    //         $per = (0.25/100)*$quantity;
    //         $quantity = $quantity-$per;
            
    //         $order = $api->marketSell($from_coin.$to_coin, $quantity);
            
    //         $to_coin_quantity = $order['cummulativeQuoteQty'];
    //         $ordr = json_encode($order);
    //         bid_log::create([
    //             "bid_id"=>$bidId,
    //             "user_id"=>$userId,
    //             "description"=>$ordr
    //         ]);

    //         user_bid_details::create([
    //             "user_id" => $userId,
    //             "bid_id"=>$bidId,
    //             "from_coin"=>$from_coin,
    //             "to_coin"=>$to_coin,
    //             "from_coin_quantity"=>$quantity,
    //             "to_coin_quantity"=>$to_coin_quantity,
    //             "status_type"=>"sell",
    //             'sell_status'=>1,
               
    //         ]);
    //         user_bid_details::where("bid_id",$bidId)->update([
    //             "sell_status"=>1
    //         ]);
    //         bid::where("id",$bidId)->update([
    //             "status"=>1
    //         ]);
    //             $usr = User::where("id",$userId)->first();

    //             $log = new bid_log();
    //             $log->user_id=$user;
    //             $log->bid_id=$bidId;
    //             $log->description="coins are ".$type." from_coin ".$from_coin." to coin ".$to_coin." of ".$usr->email." quantity ".$to_coin_quantity;
    //             $log->save();

    //             $logs[] = $log;

    //         $profit = $to_coin_quantity-$prev_quantity;

    //         $profit_per = ($profit/$prev_quantity)*100;
    //         if($profit > 0){
    //             $is_credit = 1;
    //         }
    //         else{
    //             $is_credit = 0;
    //         }
    //         user_bid_details::where('bid_id',$request->bid_id)->update([
    //             "profit"=>$profit,
    //             "profit_per"=>$profit_per,
    //             "is_credited"=>$is_credit,
    //         ]);
        
        
    //     // $user = user_bid_details::where('bid_id',$request->bid_id)->first();
    //     $usr = $userr;
    //         if($profit < 0.01){
    //             continue;exit;
    //         }

    //     $profit_amnt = (20/100)*$profit;

    //     // if($profit_amnt < 0){
    //     //     $profit_amnt = -$profit_amnt;
    //     // }
    //         wallet::create([
    //             "status"=> 1,
    //             "user_id"=>$usr->id,
    //             "amount"=>$profit_amnt,
    //             "description"=>"Fuel Debit",
    //             "wallet_type"=>"F", 
    //             "transaction_type"=>"bot_debit",
    //             "from_uid"=>$bidId
    //         ]);

    //         // bid::where("id",$request->bid_id)->update([
    //         //     "status"=>1
    //         // ]);

    //         // $log = bid_log::where("bid_id",$bidId)->get();
    //         if($profit < 0){
    //             return redirect()->back()->with(["log"=>$logs]);
    //             exit;
    //         }

    //         $active_user = $usr->id;
    //         $active_sponser = $usr->spUID;

    //         $loop = true;
    //         $lv = 1;
    //         $pre = 0;
    //         while($loop == true){
    //             if($active_sponser == "" || $active_sponser == "Admin" || $lv==8){
    //                 $loop=false;
    //                 break;
    //             }
    //             $act_sp = User::where("UID",$active_sponser)->first();
    //             if($act_sp->is_active == 0 || $lv>$act_sp->rank_level ){
    //                 $active_sponser = $act_sp->spUID;
    //                 continue; 
    //             }
    //             $rank_lvl =  $act_sp->rank_level;
    //             $com = $this->lvl_income($rank_lvl);
    //             $finalc = $com - $pre;
    //             $pre = $com;
    //             $level_com = $profit_amnt/100*$finalc;

    //             $level_com = number_format($level_com,8,'.','');

    //             wallet::create([
    //                 "transaction_type"=>"profit_gen",
    //                 "wallet_type"=>"M",
    //                 "description"=>"Generation bounus Level G".$rank_lvl,
    //                 "amount"=>$level_com,
    //                 "user_id"=>$act_sp->id,
    //                 "user_uid"=>$act_sp->UID,
    //                 "from_uid"=>$usr->UID,
    //                 "level"=>$rank_lvl
    //             ]);

    //             $lv= $rank_lvl+1; 
    //             $active_sponser = $act_sp->spUID;
    //         }
    //     }
    //     // $log = bid_log::where("bid_id",$bidId)->get();
    //         return redirect()->back()->with(["log"=>$logs]);
    // }

    // public function bedsDetails(Request $request){
    //     $user_token = $request->user_token;
    //     $user = User::where("user_token",$user_token)->where("api_key","!=","")->first();
    //     if(empty($user_token) &&  !empty($user) || empty($user)){
    //         return response()->json(["status" =>0]);
    //     }
    //     $bids = bid::join("user_bid_details","bids.id","user_bid_details.bid_id")->where("user_bid_details.user_id",$user->id)->orderBy("bids.id","desc")->take(10)->get();
    //     if(empty($bids)){
    //         return response()->json(["status" =>2]);
    //     }
    //     return response()->json(["status" =>1,"data"=>$bids]);
    // }

    // public function openOrders(Request $request){
    //     $user_token = $request->user_token;
    //     $user = User::where("user_token",$user_token)->where("api_key","!=","")->first();
    //     if(empty($user_token) &&  !empty($user) || empty($user)){
    //         return response()->json(["status" =>0]);
    //     }
    //     $bids = bid::join("user_bid_details","bids.id","user_bid_details.bid_id")->where("user_bid_details.user_id",$user->id)->where("bids.sell_to_coin",null)->orderBy("bids.id","desc")->paginate(10);
    //     if(empty($bids)){
    //         return response()->json(["status" =>2]);
    //     }
    //     $bids->map(function($data){
    //         $user = User::where("id",$data->user_id)->first();
    //         $api = new API($user->api_key,$user->secret_key);
    //         $api->useServerTime();
    //         $data->current_price = $api->price($data->to_coin.'USDT');
    //         return $data;
    //     });
    //      return response()->json(["status" =>1,"data"=>$bids]);
    // }

    // public function bedsRecords(Request $request){
    //     $user_token = $request->user_token;
    //     $user = User::where("user_token",$user_token)->where("api_key","!=","")->first();
    //     if(empty($user_token) &&  !empty($user) || empty($user)){
    //         return response()->json(["status" =>0]);
    //     }
    //     $bids = bid::join("user_bid_details","bids.id","user_bid_details.bid_id")->where("user_bid_details.user_id",$user->id)->where("user_bid_details.status_type","sell")->orderBy("bids.id","desc")->paginate(10);
    //     $bids->map(function($data){
    //         $user = user_bid_details::where("bid_id",$data->bid_id)->where("user_id",$data->user_id)->where("status_type","buy")->first();
    //         $record= user_bid_details::where("bid_id",$data->bid_id)->where("user_id",$data->user_id)->where("from_coin_quantity","<=",$user->to_coin_quantity)->where("status_type","sell")->first();
    //         if($record == null){
    //             $data->to_coin_quantity = "";
    //         }
    //         else{
    //              $data->to_coin_quantity = $record->to_coin_quantity;
    //         }
    //         $data->from_coin_quantity = $user->from_coin_quantity;
    //         $data->coin_quantity = $user->to_coin_quantity;
            
    //         return $data;
    //     });
    //     if(empty($bids)){
    //         return response()->json(["status" =>2]);
    //     }
    //     return response()->json(["status" =>1,"data"=>$bids]);
    // }

    // public function getQrCode(Request $request){
    //     $user_token = $request->user_token;
    //     $user = User::where("user_token",$user_token)->first();
    //     if(empty($user_token) &&  !empty($user) || empty($user)){
    //         return response()->json(["status" =>0]);
    //         exit;
    //     }
    //     $token = User::where("is_admin",1)->first();
    //     include app_path().'/Http/Controllers/init.php';
    //     $coin->Setup($token->private_key,$token->public_key);
    //     $basicInfo = $coin->GetBasicProfile();
    //     $username = $basicInfo['result']['public_name'];
        
    //         $amount = $request->amount;
    //         $scurrency = "USDT";
    //         $rcurrency = "USDT.TRC20";
    //         $req = [
    //             'amount' => $amount,
    //             'currency1' => $scurrency,
    //             'currency2' => $rcurrency,
    //             'buyer_email' => "info@jetbot.com",
    //             'item' => "Donate to coinpayment",
    //             'address' => "",
    //             'ipn_url' => "https://jetbot.live/jetbot/api/ipn_url"
    //         ];
    //         $result = $coin->CreateTransaction($req);
    //         order::create([
    //             "payment_id"=>$result['result']['txn_id'],
    //             "user_id"=>$user->id,
    //             "amount"=>$amount,
    //             "status_url"=>$result['result']['status_url'],
    //             "address"=>$result['result']['address']
    //         ]);
    //         callback::create([
    //             "response"=>"before status".json_encode($result['result'])
    //         ]);
    //     return response()->json(["status"=>1,"data"=>$result['result'],"qr_code"=>$result['result']['qrcode_url']]);
    // }

    // public function ipn_url(Request $request){
        
    //     callback::create([
    //         "response"=>'ipn'
    //     ]);
    //     $postdata = $_POST;
    //     $data = json_encode($postdata);
    //     callback::create([
    //         "response"=> $data
    //     ]);
    //     $payment_id = $postdata['txn_id'];
    //     $order = order::where("payment_id",$payment_id)->first();
    //     $order->wallet=$postdata['currency2'];
    //     $order->status=$postdata['status'];
    //     $order->payment_status = $postdata['status_text'];
    //     $order->status_text = "Processing";
    //     $order->save();
    //     if($postdata['status'] == "100"){
    //         callback::create([
    //             "response"=>"success".$data
    //         ]);
    //         $amount = $order->amount;
    //         $user_id = $order->user_id;
    //         $amount1 = $postdata['amount1'];
    //         $amount2 = $postdata['amount2'];
    //         if($amount1 >= $amount2){
    //                 wallet::create([
    //                     "user_id"=>$user_id,
    //                     "amount"=>$amount2,
    //                     "description"=>"amount is received from coinpayment",
    //                     "wallet_type"=>"F"
    //                 ]);
    //                 order::where("payment_id",$payment_id)->update([
    //                     "wallet_status"=>"transfer",
    //                     "status_text"=>"complete"
    //                 ]);
    //             }
    //             else{
    //                 order::where("payment_id",$payment_id)->update([
    //                     "wallet_status"=>"pending"
    //                 ]);
    //             }
    //         }
    //         return response()->json(["status"=>1]);
          
    // }

    // public function payment_status(Request $request){
    //     if(!$request->txn_id){
    //         return response()->json(["status"=>0]);
    //     }
    //     $order = order::where("payment_id",$request->txn_id)->where("status_text","!=","")->get();
    //     return response()->json(["status"=>1,"data"=>$order]);
    // }

 



    // public function lvl_income($lv){
    //     if($lv== 1){
    //         return 35;
    //     }
    //     elseif($lv== 2){
    //         return 40;
    //     }
    //     elseif($lv== 3){
    //         return 45;
    //     }
    //     elseif($lv== 4){
    //         return 50;
    //     }
    //     elseif($lv== 5){
    //         return 60;
    //     }
    //     elseif($lv== 6){
    //         return 65;
    //     }
    //     elseif($lv== 7){
    //         return 75;
    //     }
    // }

    // public function coinPrices(){
        
    //     $user = User::where("is_admin",1)->first();
    //     $api = new API($user->api_key,$user->secret_key);
    //     $api->useServerTime();
    //     $ticker = $api->prices();
       
    //     // $balances = $api->balances($ticker);
    //     // $coins = [];
    //     // $prices = [];
    //     $coins1= [];
    //     $i=0;
    //     foreach($ticker as $key=>$val){
    //         if(preg_match("/usdt/i",$key) && ($val != "" || $val!="undefined")){
    //             $key = substr($key,"0","-4");
    //             $coins1[$i]['name'] = $key;
    //             $coins1[$i]['price'] = $val;
    //             $i++;
    //         }
    //     }
    //     // foreach($balances as $key=>$bal){
    //     //     if($key == "BNB" || $key == "ETH" || $key == "BTC" || $key == "LTC" || $key == "XRP" || $key == "TRX"){
    //     //         $coins1[$i]['name'] = $key;
    //     //         $coins1[$i]['price'] = $api->price($key.'USDT');
    //     //         $i++;
    //     //     }
    //     // }
        
    //     return response()->json(["status"=>1,"prices"=>$coins1]);
    // }

    // public function coins(Request $request){
    //     $coins = coin::all();
    //     return view("admin.binanceCoins",compact('coins'));

    // }

    // public function editCoin($id){
    //     $coin= coin::findOrFail($id);
    //     return view("admin.editBinanceCoin",compact('coin'));
    // }

    // public function updateCoin(Request $request,$id){
    //     $coin= coin::findOrFail($id);
    //     $coin->value = $request->value;
    //     $coin->save();
    //     return redirect()->route("binance.allCoins")->with("success","Coins Updated Successfully");
    // }

    // public function removeSell(Request $request){
    //     $users = $request->users;
    //     foreach($users as $user){
    //         user_bid_details::where("bid_id",$request->bid_id)->where("user_id",$user)->update([
    //             "sell_status"=>1
    //         ]);
    //     }

    //     return redirect()->back()->with("success","Removed Successfully");
    // }
    // public function removeBid(Request $request){
    //     $bid_id = $request->bid_id;
    //     $users = $request->users;
    //     foreach($users as $user){
    //         $user_bids = user_bid_details::where("bid_id",$request->bid_id)->where("user_id",$user)->where("sell_status",0)->first();
    //         if(!empty($user_bids)){
    //             return redirect()->back()->with("error","Please remove from every users first");
    //             exit;
    //         }
    //     }
    //     bid::where("id",$bid_id)->update([
    //         "status"=>1
    //     ]);

    //     return redirect()->back()->with("success","Removed Successfully");
    // }

    // public function getPrice(Request $request){
    // //    $coins = coin::all();       
    // //         foreach($coins as $coin){
    // //             $ch = curl_init(); 
    // //             curl_setopt($ch, CURLOPT_URL, 'https://api.binance.com/api/v3/ticker/price?symbol='.$coin->coin_name.'USDT'); 
    // //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    // //             $data = curl_exec($ch); 
    // //             curl_close ($ch);
    // //             $data1[]= json_decode($data,true);
    // //         }
    // //         return response()->json($data1);
    // }

    // public function binanceDetails(Request $request){
    //     $sells = bid::orderBy("id","desc")->paginate();
    //     if($request->search_from){
    //         $sells = bid::where("from_coin","like","%".$request->search_from."%")->orderBy("id","desc")->paginate();
    //         $sells->appends(["search_from"=>$request->search_from]);
    //     }
    //     if($request->search_to){
    //         $sells = bid::where("to_coin","like","%".$request->search_to."%")->orderBy("id","desc")->paginate();
    //         $sells->appends(["search_to"=>$request->search_to]);

    //     }
    //     return view("admin.binanceDetails",compact('sells'));
    // }

    

  


}


