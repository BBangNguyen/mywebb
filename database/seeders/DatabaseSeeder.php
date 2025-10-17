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
            [
                'product_name' => 'iPhone 15 Pro Max',
                'product_price' => 29990000,
                'product_image' => './img/product5.png',
                'product_describe' => 'iPhone mới nhất với chip A17 Pro',
            ],
            [
                'product_name' => 'Dell XPS 15',
                'product_price' => 35990000,
                'product_image' => './img/product6.png',
                'product_describe' => 'Laptop cao cấp cho dân văn phòng',
            ],
            [
                'product_name' => 'iPad Air M2',
                'product_price' => 14990000,
                'product_image' => './img/product7.png',
                'product_describe' => 'Máy tính bảng mạnh mẽ',
            ],
            [
                'product_name' => 'AirPods Pro Gen 2',
                'product_price' => 6490000,
                'product_image' => './img/product8.png',
                'product_describe' => 'Tai nghe chống ồn tốt nhất',
            ],
            [
                'product_name' => 'Samsung Galaxy S24 Ultra',
                'product_price' => 31990000,
                'product_image' => './img/product9.png',
                'product_describe' => 'Flagship Android mạnh nhất',
            ],
            [
                'product_name' => 'Apple Watch Series 9',
                'product_price' => 10990000,
                'product_image' => './img/product10.png',
                'product_describe' => 'Đồng hồ thông minh cao cấp',
            ],
            [
                'product_name' => 'LG OLED TV 55 inch',
                'product_price' => 24990000,
                'product_image' => './img/product11.png',
                'product_describe' => 'Smart TV màn hình OLED',
            ],
            [
                'product_name' => 'PlayStation 5',
                'product_price' => 13990000,
                'product_image' => './img/product12.png',
                'product_describe' => 'Máy chơi game thế hệ mới',
            ],
        ]);
    }
}