<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
           [
            'company_name' => 'サントリー',
            'street_address' => 'コーラ',
            'representative_name' => 'テスト',
           ],
           [
            'company_name' => 'キリン',
            'street_address' => 'サイダー',
            'representative_name' => 'テスト',
           ],
          ]);
    }
}