<?php

use Faker\Factory;
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
        /*$user = \App\User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'super_admin@app.com',
            'password' => bcrypt('123123'),
        ]);
        $user->attachRole('super_admin');*/


        $faker = Factory::create('ar_JO');

        for ($i = 1; $i <= 5000; $i++) {
            $user = \App\User::create([
                'first_name' => $faker->name(1),
                'last_name' => $faker->name(2),
                'email' => str_random(3) . $faker->email,
                'password' => bcrypt('123123'),
            ]);
            $user->attachRole('admin');
        }
    }
}