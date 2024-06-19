<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\wallet;
use App\withdraw;
use App\User;

class WithdrawController extends Controller
{
   
    public function store(Request $request){
        $usr = User::where("user_token",$request->user_token)->first();
        if(empty($usr) || !$request->user_token){
            return response()->json(["status"=>0,'message'=>"Invalid User"]);
        }
        $credit = wallet::where("user_id",$usr->id)->where("status",0)->where("wallet_type","F")->sum("amount");
        $debit = wallet::where("user_id",$usr->id)->where("status",1)->where("wallet_type","F")->sum("amount");
        $balance = $credit-$debit;

       
        if($request->amount < 200){
            
            return response()->json(["status"=>0,"message"=>"Minimum 200 Amount Required!"]);
            exit;
        }
        if($request->amount > $balance){
            return response()->json(["status"=>0,"message"=>"Insufficient Balance"]);
            exit;
        }

        withdraw::create([
            "user_id"=>$usr->id,
            "amount"=>$request->amount,
            "description"=>"withdraw amount of user ".$usr->name,
            "wallet_type"=>"F",
            "type"=>$request->type,
            "value"=>$request->value,
        ]);

        wallet::create([
            "user_id"=>$usr->id,
            "user_uid"=>$usr->uid,
            "status"=>1,
            "amount"=>$request->amount,
            "description"=>"withdraw amount request of user ".$usr->name,
            "wallet_type"=>"F"
        ]);

       

        return response()->json(["status"=>1,"message"=>"Withdraw Amount Request Send Successfully"]);

    }

    public function index(){
        $withs = withdraw::orderBy("id","desc")->paginate(30);
        
        $withs->map(function($data){
            $user = User::where("id",$data->user_id)->first();
            $data->user_name = $user->name;
            $data->user_UID = $user->uid;
            return $data;
        });
        return view("admin.withdrawDetails",compact("withs"));
    }

    public function request(Request $request){
        $withs = withdraw::where("status",0)->orderBy("id","desc")->paginate();
        $withs->map(function($data){
            $user = User::where("id",$data->user_id)->first();
            $data->user_name = $user->name;
            $data->user_UID = $user->uid;
            return $data;
        });
        return view("admin.withdrawRequest",compact("withs"));
    }

    public function acceptRequest(Request $request){
        withdraw::where("id",$request->id)->update([
            "status"=>1,
            "review"=>$request->review
        ]);
        return redirect()->back();
    }
    public function rejectRequest(Request $request){
        $withdraw = withdraw::where("id",$request->id)->first();
        withdraw::where("id",$request->id)->update([
            "status"=>2,
            "review"=>$request->review
        ]);
        // User::where("id",$withdraw->user_id)->update([
        //     "status"=>0
        // ]);
        $user = User::where('id',$withdraw->user_id)->first();
        $user->status = 0;
        $user->save();
        wallet::create([
            "user_id"=>$user->id,
            "user_uid"=>$user->uid,
            "amount"=>$withdraw->amount,
            "description"=>"withdraw amount reject of user ".$user->name,
            "wallet_type"=>"F"
        ]);
        return redirect()->back();

    }
    

    
}
