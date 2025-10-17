<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed products
        DB::table('products')->insert([
            [
                'product_name' => 'Apple MacBook Pro',
                'product_price' => 17990000,
                'product_image' => './img/product1.png',
                'product_describe' => 'Máy tính đẹp',
            ],
            [
                'product_name' => 'Sony E7 Headphones',
                'product_price' => 14700000,
                'product_image' => './img/product2.png',
                'product_describe' => 'Tai nghe xịn',
            ],
            [
                'product_name' => 'Sony Xperia Z4',
                'product_price' => 4590000,
                'product_image' => './img/product3.png',
                'product_describe' => 'Ipad to',
            ],
            [
                'product_name' => 'Samsung Galaxy A50',
                'product_price' => 2780000,
                'product_image' => './img/product4.png',
                'product_describe' => 'Điện thoại xịn',
            ],
        ]);
    }
}