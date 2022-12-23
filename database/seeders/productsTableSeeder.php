<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class productsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products =[
            ['Pro_Type'=>'Vegetable'],
            ['Pro_Type'=>'Fruits'],
            ['Pro_Type'=>'Nuts'],
        ];

        foreach($products as $row){
            DB::table('products') -> insert($row);
        }
    }
}
