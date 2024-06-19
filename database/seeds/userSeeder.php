<?php

use Illuminate\Database\Seeder;
use App\User;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                "id"=>1,
               'name'=>'Admin',
               'email'=>'admin@gmail.com',
                'is_admin'=>'1',
               'password'=> bcrypt('admin'),
               'uid'=>'LN12345'
            ],
        ];
  
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
