<?php


use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \DB::table('users')->delete();

        User::insert(['id'=>1, 'name'=> 'moldovaocds', 'email'=>'moldova@yipl.com.np', 'password'=> bcrypt('moldovaocds@123'),
                      'admin'=> true ]);
    }
}