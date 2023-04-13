<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('users')->insert([
            'account_id' => 1,
            'role_id' => 1,
            'username' => 'admin',
            'password' => \Hash::make('admin'),
        ]);
        DB::table('user_info')->insert([
            'user_id' => 1,
            'fullname' => $faker->userName(),
            'phone_number' => $faker->phoneNumber(),
            'email' => $faker->email(),
            'date_of_birth' => $faker->date(),
            'gender' => 1,
            'address' => $faker->address(),
            'description' => '',
        ]);
    }
}
