<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cartDetail =[
            ['Cart_Id'=>'1','ProDe_Id'=>'1','CartDe_Quantity'=>'3'],
            ['Cart_Id'=>'1','ProDe_Id'=>'2','CartDe_Quantity'=>'4'],
            ['Cart_Id'=>'1','ProDe_Id'=>'4','CartDe_Quantity'=>'8'],
            ['Cart_Id'=>'1','ProDe_Id'=>'6','CartDe_Quantity'=>'10'],

            ['Cart_Id'=>'2','ProDe_Id'=>'1','CartDe_Quantity'=>'3'],
            ['Cart_Id'=>'2','ProDe_Id'=>'2','CartDe_Quantity'=>'4'],
            ['Cart_Id'=>'2','ProDe_Id'=>'5','CartDe_Quantity'=>'2'],
            ['Cart_Id'=>'2','ProDe_Id'=>'4','CartDe_Quantity'=>'8'],
        ];

        foreach($cartDetail as $row){
            DB::table('cart_detail') -> insert($row);
        }
    }
}
