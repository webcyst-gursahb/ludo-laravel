<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\payment;
use App\User;
use App\wallet;
use App\game_package;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function index(){
        $pays = payment::where("status",0)->orderBy("id","desc")->paginate(30);
        $pays->map(function($data){
          $user =  User::where("id",$data->user_id)->first();
          $data->user = $user;
          $data->sponser = User::where('uid',$user->spid)->first();
          return $data;
        });
        return view('admin.pendingPay',compact('pays'));
    }
    public function completedPayments(){
        $pays = payment::where("status",1)->orderBy("id","desc")->paginate(30);
        $pays->map(function($data){
            $user =  User::where("id",$data->user_id)->first();
            $data->user = $user;
            $data->sponser = User::where('uid',$user->spid)->first();

          return $data;
        });
        return view('admin.acceptedPay',compact('pays'));
    }
    public function rejectedPayments(){
        $pays = payment::where("status",2)->orderBy("id","desc")->paginate(30);
        $pays->map(function($data){
            $user =  User::where("id",$data->user_id)->first();
            $data->user = $user;
            $data->sponser = User::where('uid',$user->spid)->first();
        });
        return view('admin.rejectedPay',compact('pays'));
    }

    public function accept(Request $request){

        // $pay= payment::where('id',$request->id)->where('transaction_id',$request->trans_id)->update([
        //     'status'=>1,
        //     'amount'=>$request->amount
        // ]);
        $pay = payment::where('id',$request->id)->first();
        $pay->status = 1;
        $pay->amount = $request->amount;
        $pay->save();
        
            wallet::create([
                'amount'=>$request->amount,
                'user_id'=> $pay->user_id,
                'description'=> "Amount Recieved From Admin",
                'wallet_type'=>"epin",
            ]);
       
        return redirect()->back();
    }
    public function reject(Request $request){
        $pay= payment::where('id',$request->id)->update([
            'status'=>2,
            'review'=>$request->review
        ]);

        return redirect()->back();
    }

    public function changeProfile(){
        return view('admin.changeProfile');
    }
    public function updateProfile(Request $request){
        $user  =  User::where("is_admin",1)->first();
        if($request->password != ""){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->back()->with('success',"Profile Updated");
    }
    
    public function activateUser($id){
        $user = User::findOrFail($id);
        $user->is_active = 1;
        $user->activation_date = Carbon::now();
        $user->save();
        return redirect()->back()->with("success","User Activate Successfully");
    }
    
    
}
