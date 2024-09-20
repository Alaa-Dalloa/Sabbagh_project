<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin=\App\Models\Role::create(
        [
            'name'=>'super_admin',
            'display_name'=>'super_admin',
            'description'=>'can do any thing in this project'

        ]);

        $retail_customer=\App\Models\Role::create(
        [
            'name'=>'retail_customer',
            'display_name'=>'retail_customer',
            'description'=>'can do specific tasks'

        ]);

        $wholeSale_customer=\App\Models\Role::create(
        [
            'name'=>'wholeSale_customer',
            'display_name'=>'administor',
            'description'=>'can do any thing specific tasks'

        ]);



        $supplier=\App\Models\Role::create(
        [
            'name'=>'supplier',
            'display_name'=>'supplier',
            'description'=>'can do some things'

        ]);


        
    }
}
