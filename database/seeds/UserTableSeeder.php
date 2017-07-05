<?php


use App\User;
use Carbon\Carbon;
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

        User::insert([
            'name' => 'Moldova OCDS',
            'username' => 'superadmin',
            'password' => bcrypt('@-admin'),
            'admin' => true,
            'superadmin' => true,
            'status' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        User::insert([
            'name' => 'PPA Admin',
            'username' => 'ppa-admin',
            'password' => bcrypt('@-admin'),
            'admin' => true,
            'superadmin' => false,
            'status' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        User::insert([
            'name' => 'WB Admin',
            'username' => 'wb-admin',
            'password' => bcrypt('@-admin'),
            'admin' => true,
            'superadmin' => false,
            'status' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        User::insert([
            'name' => 'Comms Admin',
            'username' => 'comms-admin',
            'password' => bcrypt('@-admin'),
            'admin' => true,
            'superadmin' => false,
            'status' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        User::insert([
            'name' => 'IT Admin',
            'username' => 'it-admin',
            'password' => bcrypt('@-admin'),
            'admin' => true,
            'superadmin' => false,
            'status' => true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}