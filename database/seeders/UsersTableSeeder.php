<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=\App\Models\User::create(
        [
            'first_name'=>'super admin',
            'last_name'=>'null',
            'phone'=>'null',
            'governorate'=>'damascuse',
            'email'=>'super_admin@gmail.com',
            'library_name'=>'Al_sabbagh',
            'password' => Hash::make('secret1234'),
            'user_type'=>'super_admin',
            'fcm_token'=>'null',
        ]);

        //$user->attachRole('super_admin');


        $user=\App\Models\User::create(
        [
            'first_name'=>'Al_sabbagh delivery',
            'last_name'=>'null',
            'phone'=>'null',
            'governorate'=>'damascuse',
            'email'=>'supplier@gmail.com',
            'library_name'=>'Al_sabbagh',
            'password' => Hash::make('supplier1234'),
            'user_type'=>'supplier',
             'fcm_token'=>'null',

        ]);

        //$user->attachRole('supplier');
    }
}

