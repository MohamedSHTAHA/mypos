<?php

use App\Category;
use App\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $products = ['pro one', 'pro two'];

        foreach ($products as $product) {

            \App\Product::create([
                'category_id' => 1,
                'ar' => ['name' => $product, 'description' => $product . ' desc'],
                'en' => ['name' => $product, 'description' => $product . ' desc'],
                'purchase_price' => 100,
                'sale_price' => 150,
                'stock' => 100,
            ]);
        } //end of foreach  
        */



        $faker = Factory::create();

        for ($i = 10000; $i <= 10500; $i++) {
            Product::create([
                'category_id'    => Category::inRandomOrder()->first()->id,
                'ar' => ['name' => $faker->sentence(4), 'description' => $faker->paragraph()],
                'en' => ['name' => $faker->sentence(4), 'description' => $faker->paragraph()],
                'purchase_price' => 100,
                'sale_price' => rand(10, 300),
                'stock' => rand(10, 300),
                //'barcode' => $faker->unique()->randomDigit,
                'code' => $i,

            ]);
        }
    }
}
