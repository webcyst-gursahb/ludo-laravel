<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\downline;
use App\wallet;
use App\transfer;
use App\payment;
use App\withdraw;
use App\order;
use Hash;
use Auth;
use Binance\API;
use App\bid;
use App\game;
use App\game_package;

use App\setting;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\userMail;
use App\Mail\forgotMail;
use App\Mail\verifyMail;
use Illuminate\Support\Facades\Password;
use Laravel\Ui\Presets\React;

class usersController extends Controller {

    public function index() {
        $total_users = User::where("is_admin", "!=", 1)->count();

        $active_users = User::where("is_admin", "!=", 1)->where("is_active", 1)->count();

        $nonActive_users = User::where("is_admin", "!=", 1)->where("is_active", 0)->count();

        $total_beds = bid::count();

        $binance_users = User::where("is_admin", "!=", 1)->where("api_key", '!=', "")->where("secret_key", '!=', "")->count();

        $fuel_credit = wallet::where("wallet_type", "F")->where("status", 0)->sum('amount');
        $fuel_debit = wallet::where("wallet_type", "F")->where("status", 1)->sum('amount');
        $fuel_balance = $fuel_credit - $fuel_debit;

        $income_credit = wallet::where("wallet_type", "F")->where("status", 0)->sum('amount');
        $income_debit = wallet::where("wallet_type", "F")->where("status", 1)->sum('amount');
        $income_balance = $income_credit - $income_debit;

        $total_generation = wallet::where("transaction_type", "gen_active")->sum('amount');
        $profit_generation = wallet::where("transaction_type", "profit_gen")->sum('amount');

        return view('admin.home', compact('total_users', 'active_users', 'nonActive_users', 'total_beds', 'fuel_balance', 'income_balance', 'binance_users', 'total_generation', 'profit_generation'));
    }

    public function users(Request $request) {
        $users = User::where("is_admin", "!=", 1)->orderBy("id", "desc")->paginate();
        if ($request->sponser_search) {
            $users = User::where("is_admin", "!=", 1)->where(function ($q) use ($request) {
                        $q->where("spid", "like", "%" . $request->sponser_search . "%");
                    })->paginate();
            $users->appends(["sponser_search" => $request->sponser_search]);
        }
        if ($request->search) {
            $users = User::where("is_admin", "!=", 1)->where(function ($q) use ($request) {
                        $q->where("name", "like", "%" . $request->search . "%")->orWhere("phone", "like", "%" . $request->search . "%")->orWhere("email", "like", "%" . $request->search . "%")->orWhere("uid", "like", "%" . $request->search . "%")->orWhere("spid", "like", "%" . $request->search . "%");
                    })->paginate();
            $users->appends(["search" => $request->search]);
        }
        $users->map(function ($data) {
            $user = User::where("uid", $data->spid)->first();
            $data->sp_name = "";
            if ($user) {
                $data->sp_name = $user->name;
            }
            $credit = wallet::where("user_id", $data->id)->where("wallet_type", "F")->where("status", 0)->sum("amount");
            $debit = wallet::where("user_id",$data->id)->where("wallet_type", "F")->where("status", 1)->sum("amount");
            $fuel_balance = $credit - $debit;
            $epin_credit = wallet::where("user_id", $data->id)->where("wallet_type", "epin")->where("status", 0)->sum("amount");
            $epin_debit = wallet::where("user_id", $data->id)->where("wallet_type", "epin")->where("status", 1)->sum("amount");
            $epin_balance = $epin_credit - $epin_debit;
            $data->fuel_balance = $fuel_balance;
            $data->epin_balance = $epin_balance;
            $creditM = wallet::where("user_id", $data->id)->where("wallet_type", "F")->where("status", 0)->sum("amount");
            $debitM = wallet::where("user_id", $data->id)->where("wallet_type", "F")->where("status", 1)->sum("amount");
            $main_balance = $creditM - $debitM;
            $data->main_balance = $main_balance;
            return $data;
        });

        return view("admin.users", compact('users'));
    }

    public function activeUsers(Request $request) {
        $users = User::where("is_admin", "!=", 1)->where("is_active", 1)->orderBy("id", "desc")->paginate();
        if ($request->sponser_search) {
            $users = User::where("is_admin", "!=", 1)->where("is_active", 1)->where(function ($q) use ($request) {
                        $q->where("spid", "like", "%" . $request->sponser_search . "%");
                    })->paginate();
            $users->appends(["sponser_search" => $request->sponser_search]);
        }
        if ($request->search) {
            $users = User::where("is_admin", "!=", 1)->where("is_active", 1)->where(function ($q) use ($request) {
                        $q->where("name", "like", "%" . $request->search . "%")->orWhere("phone", "like", "%" . $request->search . "%")->orWhere("email", "like", "%" . $request->search . "%")->orWhere("uid", "like", "%" . $request->search . "%")->orWhere("spid", "like", "%" . $request->search . "%");
                    })->paginate();
            $users->appends(["search" => $request->search]);
        }
        $users->map(function ($data) {
            $user = User::where("uid", $data->spid)->first();
            $data->sp_name = "";
            if ($user) {
                $data->sp_name = $user->name;
            }
            $credit = wallet::where("user_id", $data->id)->where("wallet_type", "F")->where("status", 0)->sum("amount");
            $debit = wallet::where("user_id", $data->id)->where("wallet_type", "F")->where("status", 1)->sum("amount");
            $fuel_balance = $credit - $debit;
            $epin_credit = wallet::where("user_id", $data->id)->where("wallet_type", "epin")->where("status", 0)->sum("amount");
            $epin_debit = wallet::where("user_id", $data->id)->where("wallet_type", "epin")->where("status", 1)->sum("amount");
            $epin_balance = $epin_credit - $epin_debit;
            $data->fuel_balance = $fuel_balance;
            $data->epin_balance = $epin_balance;
            $creditM = wallet::where("user_id", $data->id)->where("wallet_type", "F")->where("status", 0)->sum("amount");
            $debitM = wallet::where("user_id", $data->id)->where("wallet_type", "F")->where("status", 1)->sum("amount");
            $main_balance = $creditM - $debitM;
            $data->main_balance = $main_balance;
            return $data;
        });
        return view("admin.activeUsers", compact('users'));
    }

    public function editUser($id) {
        $user = User::findOrFail($id);
        return view("admin.userEdit", compact('user'));
    }

    public function updateUser($id, Request $request) {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        // $user->rank = $request->rank;
        // $user->api_key = $request->api_key;
        // $user->secret_key = $request->secret_key;

        if ($request->password != "") {
            $user->password = Hash::make($request->password);
            $user->showPass = $request->password;
        }
        $user->save();

        return redirect()->route("admin.users")->with("success", "user updated successfully");
    }

    //get all downlines
    public function sponsers(Request $request) {
        $sponsers = downline::orderBy("id", "desc")->paginate();

        if ($request->user_id) {
            $sponsers = downline::where("user_id", "like", "%" . $request->user_id . "%")->orderBy("id", "desc")->paginate();
            $sponsers->appends(["search_uid" => $request->user_id]);
        }
        if ($request->tagsp) {
            $sponsers = downline::where("tagsp", "like", "%" . $request->tagsp . "%")->orderBy("id", "desc")->paginate();
            $sponsers->appends(["tagsp" => $request->tagsp]);
        }
        $sponsers->map(function ($data) {
            $user = User::where("uid", $data->tagsp)->first();
            $data->rank = $user->rank;
            $data->rank_level = $user->rank_level;
            return $data;
        });

        return view("admin.downline", compact("sponsers"));
    }

    //get all transaction of wallet
    public function transactions(Request $request) {
        $transactions = wallet::orderBy("id", "desc")->paginate();
        if ($request->search) {
            $user = User::where("name", "like", "%" . $request->search . "%")->orWhere("email", "like", "%" . $request->search . "%")->get();
            $transactions = wallet::whereIn('user_id', $user)->orWhere("created_at", "like", "%" . $request->search . "%")->orderBy("id", "desc")->paginate();
            $transactions->appends(["search" => $request->search]);
        }
        $transactions->map(function ($data) {
            $user = User::where("id", $data->user_id)->first();
            $data->user_name = $user->name;
            $data->user_email = $user->email;
            return $data;
        });
        return view("admin.transactions", compact("transactions"));
    }

    public function sendBal(Request $request, $id) {
        $credit = wallet::where("user_id", $id)->where("status", 0)->where("wallet_type", "F")->sum("amount");
        $debit = wallet::where("user_id", $id)->where("status", 1)->where("wallet_type", "F")->sum("amount");
        $balance = $credit - $debit;
        return view("admin.sendBal", compact('balance', 'id'));
    }

    public function sendEpin(Request $request, $id) {
        $credit = wallet::where("user_id", $id)->where("status", 0)->where("wallet_type", "epin")->sum("amount");
        $debit = wallet::where("user_id", $id)->where("status", 1)->where("wallet_type", "epin")->sum("amount");
        $balance = $credit - $debit;
        return view("admin.sendEpin", compact('balance', 'id'));
    }

    //send balance to user by admin
    public function postBal(Request $request, $id) {
        $user = User::where("id", $id)->first();
        wallet::create([
            "amount" => $request->amount,
            "user_uid" => $user->uid,
            "description" => $request->desc,
            "user_id" => $id,
            "wallet_type" => "F",
            "description" => "Fuel Income from user " . Auth::user()->name . " amount " . $request->amount,
            "from_uid" => 0
        ]);
        return redirect()->route("admin.users")->with("success", "balance send successfully");
    }

    //send epin balance to user by admin
    public function postEpin(Request $request, $id) {
        $user = User::where("id", $id)->first();
        wallet::create([
            "amount" => $request->amount,
            "user_uid" => $user->uid,
            "description" => $request->desc,
            "user_id" => $id,
            "wallet_type" => "epin",
            "description" => "Epin Income from user " . Auth::user()->name . " amount " . $request->amount,
            "from_uid" => 0
        ]);
        return redirect()->route("admin.users")->with("success", "balance send successfully");
    }

    public function addApi(Request $request) {
        $user = User::where("is_admin", 1)->first();
        $video = setting::where("type", "video")->first();
        $youtube = setting::where("type", "youtube")->first();
        $whatsapp = setting::where("type", "whatsapp")->first();
        $telegram = setting::where("type", "telegram")->first();
        $zoom = setting::where("type", "zoom")->first();
        $zoom_start = setting::where("type", "zoom_start")->first();
        $upi_id = setting::where("type", "upi_id")->first();
        $banner = setting::where("type", "banner")->first();
        $banner1 = setting::where("type", "banner1")->first();
        $banner2 = setting::where("type", "banner2")->first();
        $insta = setting::where("type", "insta")->first();
        return view("admin.addApi", compact('user', 'video', 'youtube', 'whatsapp', 'telegram', 'zoom', 'zoom_start', 'upi_id', 'banner', 'banner1', 'insta'));
    }

    public function updateApi(Request $request) {
        $video = setting::where("type", "video")->first();
        $youtube = setting::where("type", "youtube")->first();
        $whatsapp = setting::where("type", "whatsapp")->first();
        $telegram = setting::where("type", "telegram")->first();
        $zoom = setting::where("type", "zoom")->first();
        $zoom_start = setting::where("type", "zoom_start")->first();
        $upi_id = setting::where("type", "upi_id")->first();
        $banner = setting::where("type", "banner")->first();
        $banner1 = setting::where("type", "banner1")->first();
        $banner2 = setting::where("type", "banner2")->first();
        $insta = setting::where("type", "insta")->first();

        if ($request->insta) {
            if (!$insta) {
                setting::create([
                    "type" => "insta",
                    "value" => $request->insta
                ]);
            } else {
                $insta->value = $request->insta;
                $insta->save();
            }
        }

        if ($request->video) {
            if (!$video) {
                setting::create([
                    "type" => "video",
                    "value" => $request->video
                ]);
            } else {
                $video->value = $request->video;
                $video->save();
            }
        }
        if ($request->youtube) {
            if (!$youtube) {
                setting::create([
                    "type" => "youtube",
                    "value" => $request->youtube
                ]);
            } else {
                $youtube->value = $request->youtube;
                $youtube->save();
            }
        }

        if ($request->whatsapp) {
            if (!$whatsapp) {
                setting::create([
                    "type" => "whatsapp",
                    "value" => $request->whatsapp
                ]);
            } else {
                $whatsapp->value = $request->whatsapp;
                $whatsapp->save();
            }
        }
        if ($request->telegram) {
            if (!$telegram) {
                setting::create([
                    "type" => "telegram",
                    "value" => $request->telegram
                ]);
            } else {
                $telegram->value = $request->telegram;
                $telegram->save();
            }
        }
        if ($request->zoom) {
            if (!$zoom) {
                setting::create([
                    "type" => "zoom",
                    "value" => $request->zoom
                ]);
            } else {
                $zoom->value = $request->zoom;
                $zoom->save();
            }
        }
        if ($request->zoom_start) {
            if (!$zoom_start) {
                setting::create([
                    "type" => "zoom_start",
                    "value" => $request->zoom_start
                ]);
            } else {
                $zoom_start->value = $request->zoom_start;
                $zoom_start->save();
            }
        }
        if ($request->upi_id) {
            if (!$upi_id) {
                setting::create([
                    "type" => "upi_id",
                    "value" => $request->upi_id
                ]);
            } else {
                $upi_id->value = $request->upi_id;
                $upi_id->save();
            }
        }
        if ($request->banner) {
            if (!$banner) {
                if ($request->hasFile('banner')) {

                    $banner = new setting();
                    // $filename = time().'.'.$request->banner->extension();
                    $filename = $request->banner->getClientOriginalName();
                    $request->banner->move(public_path('slider'), $filename);
                    $banner->type = "banner";
                    $banner->value = $filename;
                    $banner->save();
                }
            } else {
                if ($request->hasFile('banner')) {
                    $filename = $request->banner->getClientOriginalName();
                    $request->banner->move(public_path('slider'), $filename);
                    $banner->type = "banner";
                    $banner->value = $filename;
                    $banner->save();
                }
            }
        }
        if ($request->banner1) {
            if (!$banner1) {
                if ($request->hasFile('banner1')) {

                    $banner1 = new setting();
                    $filename1 = $request->banner1->getClientOriginalName();
                    $request->banner1->move(public_path('slider'), $filename1);
                    $banner1->type = "banner1";
                    $banner1->value = $filename1;
                    $banner1->save();
                }
            } else {
                if ($request->hasFile('banner1')) {
                    $filename1 = $request->banner1->getClientOriginalName();
                    $request->banner1->move(public_path('slider'), $filename1);
                    $banner1->type = "banner1";
                    $banner1->value = $filename1;
                    $banner1->save();
                }
            }
        }
        if ($request->banner2) {
            if (!$banner2) {
                if ($request->hasFile('banner2')) {

                    $banner2 = new setting();
                    $filename2 = $request->banner2->getClientOriginalName();
                    $request->banner2->move(public_path('slider'), $filename2);
                    $banner2->type = "banner2";
                    $banner2->value = $filename2;
                    $banner2->save();
                }
            } else {
                if ($request->hasFile('banner2')) {
                    $filename2 = $request->banner2->getClientOriginalName();
                    $request->banner2->move(public_path('slider'), $filename2);
                    $banner2->type = "banner2";
                    $banner2->value = $filename2;
                    $banner2->save();
                }
            }
        }

        return redirect()->back()->with("success", "Keys Are Updated successfully");
    }

    // user register api
    public function register(Request $request) {
        $exist = User::where("email", $request->email)->get();

        if (count($exist) > 0) {
            return response()->json(["message" => "User already exist please login", "status" => 0]);
            exit;
        }
        if (!$request->spid) {
            return response()->json(["message" => "Sponser id is required", "status" => 0]);
            exit;
        }


        $usr = User::where("uid", $request->spid)->first();
        $rand = mt_rand(10000, 99999);

        $user_token = Hash::make($rand);

        $rand = "LN" . $rand;
        $uid_Exist = User::where("uid", $rand)->first();
        if ($uid_Exist) {
            return false;
        }

        if ($usr == null) {
            return response()->json(["message" => "Invalid sponser id", "status" => 0]);
        }
        $uid = $rand;
        $spid = $usr->uid;

        $user = User::create([
                    "name" => $request->name,
                    "email" => $request->email,
                    "phone" => $request->phone,
                    "password" => Hash::make($request->password),
                    "uid" => $uid,
                    "spid" => $spid,
                    "user_token" => $user_token,
                    // "api_key"=>$request->api_key,
                    // "secret_key"=>$request->secret_key,
                    "showPass" => $request->password
        ]);

        $user = User::where('uid', $uid)->first();

        $tagsp = $user->spid;
        $user_id = $user->uid;
        $while = true;
        $lv = 1;

        while ($while == true) {
            $udata = User::where("uid", $tagsp)->where("is_admin", "!=", 1)->get();
            if (count($udata) < 1) {
                $while = false;
                break;
                exit;
            }
            downline::create([
                "tagsp" => $tagsp,
                "user_id" => $user_id,
                "level" => $lv
            ]);
            $userdata = $udata[0];
            $tagsp = $userdata['spid'];
            $lv++;
        }

        $wallet = new wallet();

        $wallet->user_id = $user->id;
        $wallet->user_uid = $user->uid;
        $wallet->amount = 20;
        $wallet->wallet_type = "F";
        $wallet->transaction_type = "welcome_bonus";
        $wallet->description = "Welcome Bonus On Registration of user $user->uid";
        $wallet->save();

        // $details = [
        //     'title' => 'Thank You For Register with jetbot',
        //     // 'body'=>"Name: ".$user->name."<br> email: ".$user->email."<br> password ".$user->show_pass." <br> uid: ".$user->uid."<br> spid: ".$user->spid
        //     'name'=>$user->name,
        //     "email"=>$user->email,
        //     "password"=>$user->show_pass,
        //     "uid"=>$user->uid,
        //     "spid"=>$user->spid,
        //     "user_token"=>$user->user_token
        // ];
        // Mail::to($user->email)->send(new userMail($details));
        // $code = mt_rand(10000, 99999);
        // Mail::to($user->email)->send(new verifyMail([
        //     'title'=> "OTP: ".$code,
        //     'name'=>$user->name,
        //     "email"=>$user->email,
        //     "password"=>$user->show_pass,
        //     "uid"=>$user->uid,
        //     "spid"=>$user->spid,
        //     "user_token"=>$user->user_token
        //     // 'body'=>"Name: ".$user->name." <br/> email: ".$user->email." <br/> password ".$user->show_pass." <br/> uid: ".$user->uid."<br/> spid: ".$user->spid
        // ]));
        // User::where('email',$user->email)->update([
        //     "verified_code"=>$code
        // ]);

        return response()->json(["data" => $user, "status" => 1]);
    }

    //login user api
    public function login(Request $request) {
        $user = User::where("email", $request->email)->orWhere("uid", $request->email)->first();

        if (!empty($user) && !Hash::check($request->password, $user->password) || empty($user)) {
            return response()->json(["status" => 0, 'message' => "Invalid Credential"]);
            exit;
        }

        $user->device_id = $request->device_id;
        $user->save();
        // if($user->is_verified == 0){
        //     return response()->json(["status"=>2,"message"=>"User Not Verified"]);
        //     exit;
        // }
        return response()->json(["status" => 1, "data" => $user]);
    }

    //get login user details

    public function getUserDetails(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();

        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
            exit;
        }



    //    if(empty($usr->device_id)){
    //         return response()->json(["message"=>'Invalid User'],500);
    //    }

        $ip_address = $request->server('SERVER_ADDR');

        return response()->json(["status" => 1, "users" => $usr, 'ip_address' => $ip_address]);
    }

    public function verfiyDevice(Request $request){
                $usr = User::where("user_token", $request->user_token)->first();

        if ($request->device_id != $usr->device_id ) {
            return response()->json(["status" => 0,"message"=>"invalid device"]);
            exit;
        }

        return response()->json(["status" => 1, "message"=>"device verified"]);

    }

    //get user balance api
    public function getUserBal(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();
        if (empty($user) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        $credit = wallet::where("user_id", $user->id)->where("status", 0)->where("wallet_type", "F")->sum("amount");
        $debit = wallet::where("user_id", $user->id)->where("status", 1)->where("wallet_type", "F")->sum("amount");
        $balance = $credit - $debit;
        if ($request->type) {
            $credit = wallet::where("user_id", $user->id)->where("status", 0)->where("wallet_type", $request->type)->sum("amount");
            $debit = wallet::where("user_id", $user->id)->where("status", 1)->where("wallet_type", $request->type)->sum("amount");
            $balance = $credit - $debit;
        }


        $balance = round($balance, 2);

        return response()->json(["balance" => $balance, "status" => 1]);
    }

    public function getVideoUrl() {
        $url = setting::where("type", "video")->first();
        return response()->json(compact('url'));
    }

    // public function totalUserBal(Request $request){
    //     $user = User::where("user_token",$request->user_token)->first();
    //     if(!$user){
    //         return response()->json(["status"=>0]);
    //     }
    //     $total = wallet::where("user_id",$user->id)->where("status",0)->where("wallet_type","F")->sum("amount");
    //     return response()->json(["status"=>1,"total"=>$total]);
    // }

    public function generationIncome(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();
        if (empty($user) || !$request->user_token) {
            return response()->json(["status" => 0]);
            exit;
        }
        $credit = wallet::where("user_id", $user->id)->where("status", 0)->where("wallet_type", "F")->where("transaction_type", "Generation Income")->sum("amount");
        $debit = wallet::where("user_id", $user->id)->where("status", 1)->where("wallet_type", "F")->where("transaction_type", "Generation Income")->sum("amount");
        $balance = $credit - $debit;
        return response()->json(["status" => 1, "balance" => $balance]);
    }

    public function generationIncomeDetails(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();
        if (empty($user) || !$request->user_token) {
            return response()->json(["status" => 0]);
            exit;
        }
        $summary = wallet::where("user_id", $user->id)->where("wallet_type", "F")->where("transaction_type", "generation income")->get();
        $summary->map(function ($data) {
            if ($data->from_uid == "") {
                $data->user_name = "";
            } else {
                $user = User::where("uid", $data->from_uid)->first();
                $data->user_name = $user->name;
            }
            return $data;
        });

        return response()->json(["status" => 1, "summary" => $summary]);
    }

    // balance transfer one user to another (fuel)
    public function bal_transfer(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();
        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        $user = User::where("uid", $usr->uid)->first();

        $credit = wallet::where("user_uid", $usr->uid)->where("wallet_type", "F")->where("status", 0)->sum("amount");
        $debit = wallet::where("user_uid", $usr->uid)->where("wallet_type", "F")->where("status", 1)->sum("amount");
        $balance = $credit - $debit;

        if ($request->amount > $balance) {
            return response()->json(["status" => 2, "message" => "Insufficient Balance"]);
            exit;
        }

        transfer::create([
            "from_userId" => $usr->uid,
            "to_userId" => $request->to_userId,
            "amount" => $request->amount
        ]);

        $from_user = User::where("uid", $usr->uid)->first();
        $to_user = User::where("uid", $request->to_userId)->first();
        wallet::create([
            "user_id" => $from_user->id,
            "user_uid" => $usr->uid,
            "amount" => $request->amount,
            "status" => 1,
            "wallet_type" => "F",
            "description" => "Fuel Income debit from user " . $usr->uid . " to user " . $request->to_userId . "amount " . $request->amount,
            "from_uid" => $to_user->uid
        ]);
        wallet::create([
            "user_id" => $to_user->id,
            "user_uid" => $request->to_userId,
            "amount" => $request->amount,
            "wallet_type" => "F",
            "description" => "Fuel Income credit to user " . $request->to_userId . " from user" . $request->from_userId . "amount " . $request->amount,
            "from_uid" => $from_user->uid
        ]);

        return response()->json(["status" => 1]);
    }

    //update profile api
    public function updateProfile(Request $request) {

        $usr = User::where("user_token", $request->user_token)->first();
        if (empty($usr) || !empty($usr) && $request->user_token == "") {
            return response()->json(["status" => 0]);
        }

        $user = User::findOrFail($usr->id);
        if ($request->email != "") {
            $user->email = $request->email;
        }
        if ($request->phone != "") {
            $user->phone = $request->phone;
        }
        if ($request->name != "") {
            $user->name = $request->name;
        }
        if ($request->password != "") {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json(["status" => 1, "user" => $user]);
    }

    //wallet summary by user api
    public function walletSummary(Request $request) {

        $usr = User::where("user_token", $request->user_token)->first();

        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        if (isset($request->transaction_type)) {
            die;
            $amount = wallet::where("user_id", $usr->id)->where("transaction_type", $request->transaction_type)->paginate();

            $summary = wallet::where("user_id", $usr->id)->where("wallet_type", $request->type)->where("transaction_type", $request->transaction_type)->orderBy("id", "desc")->paginate();
            $summary->map(function ($data) {

                if ($data->from_uid == "" || $data->transaction_type == 'bot_debit') {
                    $data->user_name = "";
                } else {
                    $user = User::where("uid", $data->from_uid)->first();
                    $data->user_name = $user->name;
                    $data->user_uid = $user->uid;
                }
                return $data;
            });
            return response()->json(["status" => 1, "summary" => $summary, "amt" => $amount]);
        }

        $summary = wallet::where("user_id", $usr->id)->where("wallet_type", $request->type)->orderBy("id", "desc")->paginate();

        // dd($summary);
        $summary->map(function ($data) {

            // if($data->from_uid == "" || $data->transaction_type == 'bot_debit'){
            //     $data->user_name = "";
            // }
            // else{
            //     $user = User::where("uid",$data->from_uid)->first();
            //     $data->user_name = $user->name;
            // }
            return $data;
        });

        return response()->json(["status" => 1, "summary" => $summary]);
    }

    public function levelIncome(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();

        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        $data = wallet::where("user_id", $usr->id)->where("wallet_type", "F")->where("transaction_type", 'gen_active')->get();

        return response()->json(["status" => 1, "data" => $data]);
    }

    //get balance of user
    public function getIncomeBal(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();
        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        $credit = wallet::where("user_id", $usr->id)->where("status", 0)->where("wallet_type", "F")->sum("amount");
        $debit = wallet::where("user_id", $usr->id)->where("status", 1)->where("wallet_type", "F")->sum("amount");
        $balance = $credit - $debit;

        $balance = round($balance, 2);
        return response()->json(["status" => 1, "balance" => $balance]);
    }

    public function getLevelBonus(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();

        if (!$user || $user->name == "Admin" || !$request->user_token) {
            return response()->json(["message" => "Invalid User"], 401);
            exit;
        }

        $level_bonus = wallet::where("user_uid", $user->uid)->where("transaction_type", 'gen_active')->sum('amount');
        return response()->json(["level_bonus" => $level_bonus], 200);
    }

    public function getTotalTeam(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();
        if (!$user || $user->name == "Admin" || !$request->user_token) {
            return response()->json(["message" => "Invalid User"], 401);
        }

        $team = downline::where("tagsp", $user->uid)->count();
        return response()->json(["team" => $team], 200);
    }

    public function getTotalDirects(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();
        if (!$user || $user->name == "Admin" || !$request->user_token) {
            return response()->json(["message" => "Invalid User"], 401);
        }

        $directs = User::where("spid", $user->uid)->count();
        return response()->json(["directs" => $directs], 200);
    }

    public function getTotalWithdraw(Request $request) {
        $user = User::where('user_token', $request->user_token)->first();
        if (!$user || $user->name == "Admin" || !$request->user_token) {
            return response()->json(["message" => "Invalid User"], 401);
        }
        $withs = withdraw::where("user_id", $user->id)->where("status", 1)->sum('amount');
        return response()->json(["withs" => $withs], 200);
    }

    public function getTotalBal(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();
        if (!$usr || $usr->name == "Admin" || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        $credit = wallet::where("user_id", $usr->id)->where("status", 0)->where("wallet_type", "F")->sum("amount");
        $debit = wallet::where("user_id", $usr->id)->where("status", 1)->where("wallet_type", "F")->sum("amount");
        $balance = $credit - $debit;
        $balance = round($balance, 2);

        return response()->json(["status" => 1, "balance" => $balance]);
    }

    //get total income balance
    // public function getTotalIncomeBal(Request $request){
    //     $usr = User::where("user_token",$request->user_token)->first();
    //     if(!$usr){
    //         return response()->json(["status"=>0]);
    //     }
    //     $total = wallet::where("user_id",$usr->id)->where("status",0)->where("wallet_type","F")->sum("amount");
    //     return response()->json(["status"=>1,"total"=>$total]);
    // }
    //get user sponser downline
    public function getDownline(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();
        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }

        $downline = downline::where("tagsp", $usr->uid)->get();
        if ($request->user_id) {
            $downline = downline::where("user_id", "like", "%" . $request->user_id . "%")->where("user_token", $request->user_token)->get();
        }
        if ($request->rank) {
            $user = User::where("is_admin", "!=", 1)->where("rank", "like", "%" . $request->rank . "%")->where("user_token", $request->user_token)->first();
            $downline = downline::where("tagsp", $user->uid)->get();
        }
        if ($request->level) {
            $downline = downline::where("tagsp", $user->uid)->where("level", $request->level)->get();
        }
        $downline->map(function ($data) {
            $user = User::where("uid", $data->tagsp)->first();
            $data->rank = $user->rank;
            $usr = User::where("uid", $data->user_id)->first();
            if ($usr->is_active == 0) {
                $data->rank = "G0";
            }
            $data->user_name = $usr->name;
            $data->user = $usr;

            return $data;
        });
        return response()->json(["status" => 1, "downline" => $downline]);
    }

    public function userDirect(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();
        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        $direct = User::where("spid", $usr->uid)->get();
        $direct->map(function ($data) {
            $data->total_direct = User::where("spid", $data->uid)->count();
            $data->total_active = User::where("spid", $data->uid)->where("is_active", 1)->count();
            $data->rank = $data->rank;
            if ($data->is_active == 0) {
                $data->rank = "G0";
            }
            // $active = 0;
            // if($data->is_active == 1){
            //     $active = 1;
            // }
            // $data->total_active = $active;
            return $data;
        });
        return response()->json(["status" => 1, "direct" => $direct]);
    }

    public function userDirectDetails(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();
        $users = User::where("spid", $user->uid)->get();
        if (!$users || !$request->user_token) {
            return response()->json(["status" => 0]);
            exit;
        }
        return response()->json(["status" => 1, "data" => $users]);
    }

    public function fuelWallet(Request $request) {
        $wallets = wallet::where("wallet_type", "F")->orderBy("id", "desc")->paginate();
        if ($request->search) {
            $user = User::where("name", "like", "%" . $request->search . "%")->orWhere("email", "like", "%" . $request->search . "%")->get();
            $wallets = wallet::where("wallet_type", "F")->where(function ($q) use ($request, $user) {
                        $q->whereIn('user_id', $user)->orWhere("created_at", "like", "%" . $request->search . "%");
                    })->orderBy("id", "desc")->paginate();
            $wallets->appends(["search" => $request->search]);
        }
        $wallets->map(function ($data) {
            $user = User::where("id", $data->user_id)->first();
            $data->user_name = $user->name;
            $data->user_email = $user->email;
            return $data;
        });
        return view("admin.fuelWallet", compact('wallets'));
    }

    public function incomeWallet(Request $request) {
        $wallets = wallet::where("wallet_type", "F")->orderBy("id", "desc")->paginate();
        if ($request->search) {
            $user = User::where("name", "like", "%" . $request->search . "%")->orWhere("email", "like", "%" . $request->search . "%")->get();
            $wallets = wallet::where("wallet_type", "F")->where(function ($q) use ($request, $user) {
                        $q->whereIn('user_id', $user)->orWhere("created_at", "like", "%" . $request->search . "%");
                    })->orderBy("id", "desc")->paginate();
            $wallets->appends(["search" => $request->search]);
        }
        $wallets->map(function ($data) {
            $user = User::where("id", $data->user_id)->first();
            $data->user_name = $user->name;
            $data->user_email = $user->email;
            return $data;
        });
        return view("admin.incomeWallet", compact('wallets'));
    }

    public function withdrawMain(Request $request) {

        // return response()->json(["status"=>0,"message"=>"Withdraw Request Working After Monday"]);
        // exit;

        $usr = User::where("user_token", $request->user_token)->first();
        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }

        $credit = wallet::where("user_uid", $usr->uid)->where("wallet_type", "F")->where("status", 0)->sum("amount");
        $debit = wallet::where("user_uid", $usr->uid)->where("wallet_type", "F")->where("status", 1)->sum("amount");
        $balance = $credit - $debit;
        if ($request->amount > $balance) {
            return response()->json(["status" => 0, "Insufficient Balance"]);
            exit;
        }

        wallet::create([
            "amount" => $request->amount - 2,
            "user_uid" => $usr->uid,
            "user_id" => $usr->id,
            "status" => 1,
            "wallet_type" => "F",
            "description" => "withdraw balance from user " . $usr->name . " amount " . $request->amount,
            "from_uid" => $usr->uid
        ]);

        withdraw::create([
            "user_id" => $usr->id,
            "amount" => $request->amount,
            "description" => "withdraw balance from user " . $usr->name . " amount " . $request->amount,
            "wallet_type" => "F"
        ]);

        return response()->json(["status" => 1]);
    }

    public function withdrawDetails(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();
        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        // $summary = wallet::where("user_id",$usr->id)->where("wallet_type","F")->where("status",1)->get();
        // $summary->map(function($data){
        //     $withdraw = withdraw::where("user_id",$data->user_id)->first();
        //     if(!empty($withdraw)){
        //         $data->withdraw = $withdraw;
        //         $data->withdraw_status = $withdraw->status;
        //     }
        //     return $data;
        // });
        $summary = withdraw::where('user_id', $usr->id)->get();
        $summary->map(function ($data) {
            $user = User::where('id', $data->user_id)->first();
            $data->user_name = $user->name;
            return $data;
        });

        return response()->json(["status" => 1, "summary" => $summary]);
    }

    public function getUserName(Request $request) {
        $user = User::where("uid", $request->uid)->first();
        if (isset($user->name) && !empty($user->name)) {
            return response()->json(["status" => 1, "user_name" => $user->name]);
        } else {
            return response()->json(["status" => 0]);
        }
    }

    public function referralLink(Request $request) {
        // $refr_id = $request->refr_id;
        //  return view("admin.referPage",compact('refr_id'));
        return view("admin.referPage");
    }

    public function link(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();

        return response()->json(["link" => "https://drive.google.com/u/0/uc?id=17J-WS2ZLo0qPt1LOCUFdNObV_Fkgw45q&export=download", "uid" => $user->uid, 'message' => "Download the app from the link and register with the given referral id."]);
    }

    public function bindApi(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();
        if (!$request->user_token || empty($usr)) {
            return response()->json(["status" => 0]);
        }

        if ($request->api_key == "" && $request->secret_key == "") {
            return response()->json(["status" => 0]);
        }

        User::where("id", $usr->id)->update([
            "api_key" => $request->api_key,
            "secret_key" => $request->secret_key
        ]);
        return response()->json(["status" => 1]);
    }

    public function profitIncome(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();
        if (empty($user) || !$request->user_token) {
            return response()->json(["status" => 0]);
            exit;
        }
        $balance = wallet::where("user_id", $user->id)->where("status", 0)->where("wallet_type", "F")->where("transaction_type", "Profit Generation Income")->sum("amount");
        return response()->json(["status" => 1, "balance" => $balance]);
    }

    public function profitIncomeDetails(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();
        if (empty($user) || !$request->user_token) {
            return response()->json(["status" => 0]);
            exit;
        }
        $details = wallet::where("user_id", $user->id)->where("status", 0)->where("wallet_type", "F")->where("transaction_type", "Profit Generation Income")->paginate();
        $details->map(function ($data) {
            if ($data->from_uid == "") {
                $data->user_name = "";
            } else {
                $user = User::where("uid", $data->from_uid)->first();
                $data->user_name = $user->name;
            }
            return $data;
        });
        return response()->json(["status" => 1, "details" => $details]);
    }

    public function directReferral(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();
        if (empty($user) || !$request->user_token) {
            return response()->json(["status" => 0]);
            exit;
        }
        $referrals = DB::select('SELECT *,count(*) as cnt FROM `downlines` where tagsp="' . $user->uid . '" GROUP by level');
        $referrals = collect($referrals);
        //  $direct = User::where("spid",$usr->uid)->where("is_active",1)->count();

        $referrals->map(function ($data) {
            $usr = User::where("uid", $data->user_id)->first();
            $data->spid = $usr->spid;
            return $data;
        });
        return response()->json(["status" => 1, "referrals" => $referrals]);
    }

    public function directReferralDetails(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();
        if (empty($user) || !$request->user_token) {
            return response()->json(["status" => 0]);
            exit;
        }
        $referrals = downline::where("level", $request->level)->where("tagsp", $user->uid)->get();
        $referrals->map(function ($data) {

            $user = User::where("uid", $data->user_id)->first();
            if ($user) {

                $data->rank = $user->rank;
                if ($user->is_active == 0) {
                    $data->rank = "G0";
                }
                $data->name = $user->name;
                $data->rank_level = $user->rank_level;
                $data->is_active = $user->is_active;
            }
            return $data;
        });

        return response()->json(["status" => 1, "details" => $referrals]);
    }

    public function totalDirects(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();
        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        $direct = User::where("spid", $usr->uid)->count();
        return response()->json(["status" => 1, "directs" => $direct]);
    }

    public function totalActiveDirects(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();
        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        $direct = User::where("spid", $usr->uid)->where("is_active", 1)->count();
        return response()->json(["status" => 1, "directs" => $direct]);
    }

    public function totalTeam(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();
        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }

        $downline = downline::where("tagsp", $usr->uid)->count();
        return response()->json(["status" => 1, "team" => $downline]);
    }

    public function totalActiveTeam(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();
        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }

        $downline = downline::where("tagsp", $usr->uid)->where("rank_level", ">", 0)->count();
        return response()->json(["status" => 1, "team" => $downline]);
    }

    public function forgotPwd(Request $request) {
        $rand = mt_rand(10000, 99999);
        $user = User::where("email", $request->email)->first();
        if (empty($user)) {
            return response()->json(["status" => 0, "message" => "Invalid User"]);
            exit;
        }
        $details = [
            'title' => 'Dear  ' . $user->name,
            'body' => "Your OTP is " . $rand
        ];

        Mail::to($user->email)->send(new forgotMail($details));

        User::where("email", $user->email)->update([
            "forgot_code" => $rand
        ]);
        return response()->json(["status" => 1]);
    }

    public function checkOTP(Request $request) {
        $user = User::where("email", $request->email)->first();
        if (empty($user)) {
            return response()->json(["status" => 0, "message" => "Invalid User"]);
            exit;
        }

        $code = $user->forgot_code;
        $reqCode = $request->otp;
        if ($reqCode != $code) {
            return response()->json(["status" => 2, "message" => "Wrong OTP"]);
            exit;
        }
        return response()->json(["status" => 1]);
    }

    public function updatePwd(Request $request) {
        $user = User::where("email", $request->email)->first();
        if (empty($user)) {
            return response()->json(["status" => 0, "message" => "Invalid User"]);
            exit;
        }
        User::where("email", $user->email)->update([
            "password" => Hash::make($request->password),
            "show_pass" => $request->password
        ]);

        return response()->json(["status" => 1]);
    }

    public function orderDetails(Request $request) {
        $user_token = $request->user_token;
        $user = User::where("user_token", $user_token)->where("api_key", "!=", "")->first();
        if (empty($user_token) && !empty($user) || empty($user)) {
            return response()->json(["status" => 0]);
        }
        $orders = order::where("user_id", $user->id)->get();
        return response()->json(["status" => 1, "orders" => $orders]);
    }

    public function user_amount(Request $request) {
        $user_token = $request->user_token;
        $user = User::where("user_token", $user_token)->first();
        if (empty($user_token) && !empty($user) || empty($user)) {
            return response()->json(["status" => 0]);
        }
        $orders = order::where("user_id", $user->id)->sum('amount');
        return response()->json(["status" => 1, "amount" => $orders]);
    }

    public function binanceBal(Request $request) {
        $user_token = $request->user_token;
        $user = User::where("user_token", $user_token)->first();
        if (empty($user_token) && !empty($user) || empty($user)) {
            return response()->json(["status" => 0]);
        }
        if ($user->api_key != "" && $user->secret_key != "") {
            $api = new API($user->api_key, $user->secret_key);
            $api->useServerTime();
            $ticker = $api->prices();
            $balances = $api->balances($ticker);
            $balance = $balances['USDT']['available'];
            return response()->json(["status" => 1, "balance" => $balance]);
        } else {
            return response()->json(["status" => 2, "message" => "User not connected with Binance"]);
        }
    }

    public function verifyEmail(Request $request) {
        $user = User::where("email", $request->email)->first();
        if ($user->verified_code != $request->code) {
            return response()->json(["status" => 0, "message" => "Invalid OTP Please Resend It"]);
            exit;
        }
        if (empty($user)) {
            return response()->json(["status" => 2, "message" => "Invalid User"]);
            exit;
        }
        User::where("email", $user->email)->update([
            "is_verified" => 1
        ]);
        return response()->json(["status" => 1, "success" => "Email verified successfully!"]);
    }

    public function resendEmail(Request $request) {
        $user = User::where("email", $request->email)->first();
        if (empty($user)) {
            return response()->json(["status" => 0, "message" => "Invalid Email Address"]);
            exit;
        }
        $rand = mt_rand(10000, 99999);
        Mail::to($request->email)->send(new verifyMail([
                    'title' => "Verify Email",
                    'body' => "Your Verification OTP is " . $rand
        ]));

        User::where('email', $request->email)->update([
            "verified_code" => $rand
        ]);

        return response()->json(["status" => 1, "success" => "Verification Email Sent!"]);
    }

    public function updateWithdrawalAddress(Request $request) {
        $token = $request->user_token;
        if (!isset($token)) {
            return response()->json(["status" => 0, "Invalid User Token"]);
            exit;
        }

        $user = User::where("user_token", $request->user_token)->first();
        if (empty($user)) {
            return response()->json(["status" => 0, "message" => "Invalid User"]);
        }
        User::where("id", $user->id)->update([
            "withdraw_address" => $request->address
        ]);

        return response()->json(["status" => 1, "success" => "Address Updated"]);
    }

    public function MainToFuel(Request $request) {
        $usr = User::where("user_token", $request->user_token)->first();
        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }

        $credit = wallet::where("user_uid", $usr->uid)->where("wallet_type", "F")->where("status", 0)->sum("amount");
        $debit = wallet::where("user_uid", $usr->uid)->where("wallet_type", "F")->where("status", 1)->sum("amount");
        $balance = $credit - $debit;

        if ($request->amount > $balance) {
            return response()->json(["status" => 2, "message" => "Insufficient Balance"]);
            exit;
        }

        $amount = $request->amount - 1;
        transfer::create([
            "from_userId" => $usr->uid,
            "to_userId" => $usr->uid,
            "amount" => $amount
        ]);

        $from_user = User::where("uid", $usr->uid)->first();
        wallet::create([
            "user_id" => $from_user->id,
            "user_uid" => $usr->uid,
            "amount" => $amount,
            "status" => 1,
            "wallet_type" => "F",
            "description" => "Transfer Main Wallet to Fuel Wallet",
            "from_uid" => $usr->uid
        ]);
        wallet::create([
            "user_id" => $from_user->id,
            "user_uid" => $usr->uid,
            "amount" => $amount,
            "wallet_type" => "F",
            "description" => "Transfer Main Wallet to Fuel Wallet",
            "from_uid" => $usr->uid
        ]);
        return response()->json(["status" => 1]);
    }

    public function payment(Request $request) {

        $paym = payment::where('transaction_id', $request->transaction_id)->first();
        if ($paym) {
            return response()->json(["res" => " transaction Id already exist"], 401);
        } else {
            $user = User::where('user_token', $request->user_token)->first();
            $pay = new payment();
            $pay->user_id = $user->id;
            $pay->user_name = $user->name;
            // $pay->upi_id = $request->upi;
            $pay->transaction_id = $request->transaction_id;
            $pay->amount = $request->amount;
            if ($request->hasFile('image')) {
                $file = $request->image;
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('transaction_slips'), $filename);
                $pay->screen_shot = $filename;
            }
            $pay->save();

            return response()->json(["res" => "payment successfull", 'data' => $pay], 200);
        }
    }

    public function appVersion() {
        return response()->json(['version' => "v4", 'url' => 'https://drive.google.com/file/d/1QAaJuw9HWygKix4XIdd44r_NdNkVqjZl/view']);
    }

    public function activationDetails(Request $request) {
        $user = User::where('user_token', $request->user_token)->first();

        $wallet = wallet::where('wallet_type', 'epin')->where("status", 1)->where('from_uid', $user->uid)->get();
        $wallet->map(function ($data) {
            $data->user = User::where('uid', $data->user_uid)->first();
            return $data;
        });
        return response()->json(compact('wallet'));
    }

    public function details(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();

        if (!$user || $user->name == "Admin" || !$request->user_token) {
            return response()->json(["message" => "Invalid User"], 401);
            exit;
        }

        $level_bonus = wallet::where("user_uid", $user->uid)->where("transaction_type", 'gen_active')->sum('amount');
        $team = downline::where("tagsp", $user->uid)->count();
        $directs = User::where("spid", $user->uid)->count();
        $withs = withdraw::where("user_id", $user->id)->where("status", 1)->sum('amount');
        $credit = wallet::where("user_id", $user->id)->where("status", 0)->where("wallet_type", "F")->sum("amount");
        $debit = wallet::where("user_id", $user->id)->where("status", 1)->where("wallet_type", "F")->sum("amount");
        $balance = $credit - $debit;
        $balance = round($balance, 2);
        $ecredit = wallet::where("user_id", $user->id)->where("status", 0)->where("wallet_type", "epin")->sum("amount");
        $edebit = wallet::where("user_id", $user->id)->where("status", 1)->where("wallet_type", "epin")->sum("amount");
        $ebalance = $ecredit - $edebit;
        $ebalance = round($ebalance, 2);
        $totalGameLevelIncome = wallet::where("user_id", $user->id)->where("transaction_type", "game_level")->orderBy('id', 'DESC')->sum("amount");

        return response()->json(["level_bonus" => $level_bonus, "team" => $team, 'directs' => $directs, 'withs' => $withs, 'balance' => $balance, 'epinBalance' => $ebalance,"totalGameLevelIncome"=>$totalGameLevelIncome], 200);
    }

    public function fundHistory(Request $request) {
        $user = User::where("user_token", $request->user_token)->first();
        $payemnts = payment::where('user_id', $user->id)->get();
        return response()->json($payemnts);
    }

    public function socialLinks() {
        $setting = setting::all();
        return response()->json($setting);
    }

    public function getName(Request $request) {

        $user = User::where('uid', $request->uid)->first();
        if (!$request->uid || $request->uid == "LN12345" || !$user) {
            return response()->json(['message' => 'Something Went Wrong', 'status' => 0]);
        }
        return response()->json($user->name);
    }

    public function updateImg(Request $request) {

        $user = User::where('user_token', $request->user_token)->first();

        if (!$request->image || !$user) {
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong']);
        }
        if (gettype($request->image == 'String')) {

            $user->image = $request->image;
        } else {
            $filename = time() . '.' . $request->image->extension();
            $request->image->move(public_path('profile'), $filename);
            $user->image = $filename;
        }
        $user->image_type = $request->image_type;
        $user->save();

        return response()->json(['status' => 1, 'message' => 'Profile Image Updated']);
    }


    public function gamePackages() {
        $packages = game_package::where("status",2)->get();
        return response()->json(compact('packages'));

    }


    public function gameTestPackages() {
      $packages = game_package::where("status",0)->get();
      return response()->json(compact('packages'));
    }

    public function gameLevelIncome(Request $request){


        $usr = User::where("user_token", $request->user_token)->first();


        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        $data = wallet::where("user_id", $usr->id)->where("transaction_type", "game_level")->orderBy('id', 'DESC')->get();
        $data->map(function($dat){
            $dat->user_name = "";
            if($dat->from_uid != ""){
                $user = User::where("uid",$dat->from_uid)->first();
                $dat->user_name = $user->name;
            }
            return $dat;
        });
        return response()->json(["status" => 1, "data" => $data]);
    }

 

    public function gameWinDetails(Request $request){


        $usr = User::where("user_token", $request->user_token)->first();

        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        $details = wallet::where("user_id", $usr->id)->where("transaction_type", "win_amount")->orderBy('id', 'DESC')->paginate(100);
        // $details = game::where("user1", $usr->id)->orWhere("user2",$usr->id)->orderBy('id', 'DESC')->paginate(100);
        
        return response()->json(["status" => 1, "data" => $details]);
    }

    public function gameLoseDetails(Request $request){


        $usr = User::where("user_token", $request->user_token)->first();

        if (empty($usr) || !$request->user_token) {
            return response()->json(["status" => 0]);
        }
        $details = game::where("user2", $usr->id)->orderBy("id","desc")->paginate(100);
        $details->map(function($data){
            $wallet = wallet::where("user_id",$data->user2)->where("game_id",$data->game_id)->where("transaction_type","game_join")->first();
            if($wallet){
                $data->amount = $wallet->amount;
                $data->description = "Lose Amount From Game ".$data->game_id;
                return $data;
            }
        });
        
        return response()->json(["status" => 1, "data" => $details]);
    }


    public function gameRecords(){
        $usr = User::where("user_token", $request->user_token)->first();

        $games = game::where("user1",$usr->id)->orWhere('user2',$usr->id)->get();
        $games->map(function($data){
            $status = "win";
            if($data->user2 == $usr->id){
                $status = "lose";
            }
            $data->status = $status;
            return $data;
        });
    }

    public function test(Request $request){
        $games = game::orderBy("id","desc")->get();
        $data = [];
        foreach($games as $game){
            $wallets = wallet::where("description", "like", "%$game->game_id%")->where("transaction_type","win_amount")->get();
            if($wallets->count() > 1){
            $data[] = $wallets;
                DB::table('duplicates')->insert([
                    "game_id" => $game->game_id
                ]);
             }
        }

        // $data = game::whereDate("created_at", ">=", "25-01-2023")->get();
        return response()->json($data);
    }

}
