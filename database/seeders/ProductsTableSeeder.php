<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
        [
            'company_id' => 1,
            'product_name' => '商品A',
            'price' => 100,
            'stock' => 20,
            'comment' => 'テスト',
            
        ],
    ]);

    }
}