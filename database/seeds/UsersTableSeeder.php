<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
         'first_name'=>'super',
         'last_name'=>'admin',
         'email'=>'super_admin@super_admin.com',
         'password'=>Hash::make('super_admin@super_admin.com'),


        ]);
        $user->attachRole('super_admin');

    }
}
