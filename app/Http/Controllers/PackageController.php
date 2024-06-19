<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\package;
use App\game_package;
use App\package_activation;
use App\downline;
use App\wallet;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\userMail;

class PackageController extends Controller
{
    public function index(){
        $packages = package::orderBy("id","desc")->paginate();
        return view("admin.packages",compact("packages"));
    }

    public function add(){
        return view("admin.addPackage");

    }

    public function store(Request $request){
        package::create([
            "name"=>$request->name,
            "amount"=>$request->amount,
            "type"=>$request->type
        ]);
        return redirect()->route("admin.packages")->with("success","package created successfully");
    }

    public function edit($id){
        $package = package::findOrFail($id);
        return view("admin.editPackage",compact('package'));
    }

    public function update(Request $request,$id){
        package::where("id",$id)->update([
            "name"=>$request->name,
            "amount"=>$request->amount
        ]);

        return redirect()->route("admin.packages")->with("success","package updated successfully");
    }

    public function delete($id){
        package::where("id",$id)->delete();
        return redirect()->back()->with("success","package deleted successfully");
    }



    public function packages(){

        $packages = package::orderBy("id","desc")->first();
        return response()->json(["packages"=>$packages,"status"=>1]);

    }

    public function activatePackage(Request $request){

        $usr = User::where("user_token",$request->user_token)->first();

        $ussr = User::where("uid",$request->uid)->first();

        if(!$usr || !$ussr){
            return response()->json(["message"=>"Invalid User","status"=>0]);
        }
        $credit = wallet::where("user_id",$usr->id)->where("status",0)->where("wallet_type","epin")->sum("amount");
        $debit = wallet::where("user_id",$usr->id)->where("status",1)->where("wallet_type","epin")->sum("amount");
        $balance = $credit-$debit;

        $package = package::where("id",$request->package_id)->first();

        if(!$package){
            return response()->json(["status"=>0,"message"=>"Invalid Package"]);
            exit;
        }

        if($package->amount > $balance){
            return response()->json(["status"=>0,"message"=>"Insufficient Balance"]);
            exit;
        }

        $user = User::where("id",$ussr->id)->first();
        if(!$user){
            return response()->json(["status"=>0,"message"=>"Invalid User"]);
            exit;
        }

        if($user->is_active == 1){
            return response()->json(["status"=>0,"message"=>"User Package already active"]);
            exit;
        }

        package_activation::create([
            "package_id"=>$request->package_id,
            "user_id"=>$ussr->id,
            "login_id"=>$ussr->id
        ]);

        // $user = User::where("id",$usr->id)->update([
        //     "is_active"=>1,
        //     "package_id"=>$request->package_id
        // ]);
        $user = User::findOrFail($ussr->id);
        $user->is_active = 1;
        $user->package_id = $request->package_id;
        $user->activation_date = Carbon::now();
        $user->save();
        

        downline::where("user_id",$user->uid)->update([
            "rank"=>"G1",
            "rank_level"=>1,
            "activation_date"=>Carbon::now()
        ]);

        wallet::create([
            "user_id"=>$usr->id,
            "user_uid"=>$user->uid,
            "amount"=>$package->amount,
            "status"=>1,
            "wallet_type"=>"epin",
            "from_uid"=>$usr->uid,
            "description"=>"Package active of user ".$user->uid." amount".$request->amount,
        ]);

        $sponser = User::where("uid",$usr->spid)->first();
        
        $active = $sponser->is_active;


        // if($active == 1){
        // $sponsers = User::where("spid",$user->spid)->where("is_active",1)->get();
        // $total_sponser = $sponsers->count();
        // // echo $user->spid .' spid<br>';
        // $active_sp = downline::where("tagsp",$user->spid)->where("rank_level","!=",0)->get();
        // // echo $active_sp->count() .' directteam<br>';

        // if($total_sponser >=2  && $active_sp->count() >= 10){
        //      User::where("uid",$user->spid)->update([
        //         "rank"=>"G2",
        //         "rank_level"=>2
        //     ]);
        //     downline::where("user_id",$user->spid)->update([
        //         "rank"=>"G2",
        //         "rank_level"=>2
        //     ]);
        // }
        // }

            $active_user = $ussr->id;
            $active_sponser = $ussr->spid;

            $loop = true;
            $lv = 1;
            $pre = 0;

            while($loop == true){

                if($active_sponser == "" || $active_sponser == "LN12345" || $lv==11){
                    $loop=false;
                    break;exit;
                }

                $act_sp = User::where("uid",$active_sponser)->first();

                if($act_sp->is_active == 0  ){
                    $lv++;
                    $active_sponser = $act_sp->spid;
                    continue;exit;
                }
               
                $com = $this->lvl_income($lv);

                $level_com = $com;

                wallet::create([
                    "transaction_type"=>"gen_active",
                    "wallet_type"=>"F",
                    "description"=>"generation bounus Level ".$lv,
                    "amount"=>$level_com,
                    "user_id"=>$act_sp->id,
                    "user_uid"=>$act_sp->uid,
                    "from_uid"=>$ussr->uid,
                    "level"=>$lv
                ]);

                 $lv++;
                $active_sponser = $act_sp->spid;
            }

            $details = [
                'title' => 'Premium package activated',
                'body' => "Your Package is now activated"
            ];

            //Mail::to($user->email)->send(new userMail($details));


        return response()->json(["status"=>1,"message"=>"Activation Done",'data'=>$user]);

    }



    public function lvl_income($lv){
        if($lv== 1){
            return 100;
        }
        elseif($lv== 2){
            return 20;
        }
        elseif($lv== 3){
            return 10;
        }
        elseif($lv== 4){
            return 10;
        }
        elseif($lv== 5){
            return 10;
        }
        elseif($lv== 6){
            return 10;
        }
        elseif($lv== 7){
            return 10;
        }
        elseif($lv== 8){
            return 10;
        }
        elseif($lv== 9){
            return 10;
        }
        elseif($lv== 10){
            return 10;
        }

    }


    public function gameIndex(){
        $packages = game_package::orderBy("id","desc")->paginate();
        return view("admin.game_packages",compact("packages"));
    }

    public function gameAdd(){
        return view("admin.add_gamePackage");

    }

    public function gameStore(Request $request){
        game_package::create([
            "amount"=>$request->amount,
            "admin_fee"=>$request->admin_fee,
            "win_amount"=>$request->win_amount
        ]);
        return redirect()->route("admin.gamePackages")->with("success","package created successfully");
    }

    public function gameEdit($id){
        $package = game_package::findOrFail($id);
        return view("admin.edit_gamePackage",compact('package'));
    }

    public function gameUpdate(Request $request,$id){
        game_package::where("id",$id)->update([
            "amount"=>$request->amount,
            "admin_fee"=>$request->admin_fee,
            "win_amount"=>$request->win_amount
        ]);

        return redirect()->route("admin.gamePackages")->with("success","package updated successfully");
    }

    public function gameDelete($id){
       game_package::where("id",$id)->delete();
        return redirect()->back()->with("success","package deleted successfully");
    }

}
