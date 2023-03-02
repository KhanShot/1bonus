<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ali',
            'surname' => 'Rymkhanov',
//            'email' => 'admin@admin.com',
            'phone' => '9967472974768',
            'type' => 'user',
            'gender' => 'm',
            'married' => true,
            'birthday' => '1999-01-24',
//            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'password' => Hash::make('user123'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
