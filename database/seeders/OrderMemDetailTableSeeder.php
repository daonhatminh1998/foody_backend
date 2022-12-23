<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderMemDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderDetail =[
            ['ORD_Id'=>'1','ProDe_Id'=>'1','ORDe_Quantity'=>'3','ORDe_Price'=>'688.2'],
            ['ORD_Id'=>'1','ProDe_Id'=>'2','ORDe_Quantity'=>'4','ORDe_Price'=>'1141.6'],
            ['ORD_Id'=>'1','ProDe_Id'=>'4','ORDe_Quantity'=>'8','ORDe_Price'=>'2123.2'],
        ];

        foreach($orderDetail as $row){
            DB::table('order_mem_detail') -> insert($row);
        }
    }
}
