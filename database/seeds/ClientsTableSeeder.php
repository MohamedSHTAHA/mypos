<?php

use App\Client;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$clients = ['عميل جارى', 'ahmed', 'mohamed'];

        foreach ($clients as $client) {

            \App\Client::create([
                'name' => $client,
                'phone' => '011111112',
                'address' => 'haram',
            ]);
        } //end of foreach*/
        \App\Client::create([
            'name' => 'عميل جارى',
            'phone' => '011111112',
            'address' => 'haram',
        ]);

        $faker = Factory::create('ar_JO');

        for ($i = 1; $i <= 100; $i++) {
            Client::create([
                'name'    => $faker->name(3),
                'address' => $faker->company,
                'phone' => $faker->phoneNumber,

            ]);
        }
    }
}
