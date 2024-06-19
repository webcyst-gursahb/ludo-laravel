<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\sp_downline;

class levelCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'level:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

     
    public function handle()
    {
        $users = User::where("is_admin","!=",1)->where("rank_level",">=","2")->where("rank_level","!=","8")->get();
        
          foreach($users as $user){
            //   print_r($user->rank_level);
              $rank_lvl = $user->rank_level;
              $new_rank = $rank_lvl+1;
              $data_arr = $this->lvl($user->rank_level);
              $direct_arr =  $data_arr['direct'];
              $achiever_arr =  $data_arr['achiever'];
              $achiever_level =  $data_arr['achiever_level'];
              $team_arr =  $data_arr['team'];
              $clevel =  $data_arr['clevel'];
             
              $sponsers = User::where("spUID",$user->UID)->where("is_active",1)->get();
              $total_sponser = $sponsers->count();
              $achiever = User::where("spUID",$user->UID)->where("rank_level",$achiever_level)->get();
              $active_sp = sp_downline::where("tagsp",$user->UID)->where("rank_level","!=",0)->get();
              if($total_sponser >=$direct_arr  && $active_sp->count() >= $team_arr &&  $achiever_arr <= $achiever->count()){
                   User::where("UID",$user->UID)->update([
                      "rank"=>$clevel,
                      "rank_level"=>$new_rank
                  ]);
                  sp_downline::where("user_id",$user->UID)->update([
                      "rank"=>$clevel,
                      "rank_level"=>$new_rank
                  ]);
              }
          }
    }

    public function lvl($level){
        // if($level == 2){
        //     $arr = ["direct"=>2,"achiever"=>1,"achiever_level"=>2,"team"=>11,"clevel"=>"G3"];
        //     return $arr;
            
        // }
        // elseif($level == 3){
        //     $arr = ["direct"=>3,"achiever"=> 1,"achiever_level"=>3,"team"=>12,"clevel"=>"G4"];
        //     return $arr;
        // }
        // elseif($level == 4){
        //     $arr = ["direct"=>4,"achiever"=> 1,"achiever_level"=>4,"team"=>13,"clevel"=>"G5"];
        //     return $arr;
        // }
        // else if($level == 5){
        //     $arr = ["direct"=>5,"achiever"=> 1,"achiever_level"=>5,"team"=>14,"clevel"=>"G6"];
        //     return $arr;
        // }
        // elseif($level == 6){
        //     $arr = ["direct"=>6,"achiever"=> 1,"achiever_level"=>6,"team"=>15,"clevel"=>"G7"];
        //     return $arr;
        // }
        // elseif($level == 7){
        //     $arr = ["direct"=>6,"achiever"=> 1,"achiever_level"=>7,"team"=>16,"clevel"=>"G8"];
        //     return $arr;
        // }
        if($level == 2){
            $arr = ["direct"=>3,"achiever"=>2,"achiever_level"=>2,"team"=>50,"clevel"=>"G3"];
            return $arr;
            
        }
        else if($level == 3){
            $arr = ["direct"=>5,"achiever"=> 3,"achiever_level"=>3,"team"=>250,"clevel"=>"G4"];
            return $arr;
        }
        else if($level == 4){
            $arr = ["direct"=>7,"achiever"=> 3,"achiever_level"=>4,"team"=>750,"clevel"=>"G5"];
            return $arr;
        }
        else if($level == 5){
            $arr = ["direct"=>9,"achiever"=> 3,"achiever_level"=>5,"team"=>2000,"clevel"=>"G6"];
            return $arr;
        }
        else if($level == 6){
            $arr = ["direct"=>12,"achiever"=> 3,"achiever_level"=>6,"team"=>8000,"clevel"=>"G7"];
            return $arr;
        }
        else if($level == 7){
            $arr = ["direct"=>12,"achiever"=> 3,"achiever_level"=>7,"team"=>8000,"clevel"=>"G8"];
            return $arr;
        }
    }
}