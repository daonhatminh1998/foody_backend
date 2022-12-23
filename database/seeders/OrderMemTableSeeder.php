<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderMemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders =[
            ['ORD_DateTime'=>now(),
            'Mem_Id'=>'1',
            'ORD_Code'=>date('ymd\0\0\0\1'),

            "ORD_Name"=>'Đào Nhật Minh',
            "ORD_Phone"=>'0382300327',
            'ORD_Address'=>'254/19A Lê Văn Thọ Phường 11, Quận Gò Vấp',
            
            'ORD_CusNote'=>'Delivery as fast as you can.',
            'ORD_AdNote'=>'2dsf'],
        ];

        foreach($orders as $row){
            DB::table('order_mem') -> insert($row);
        }
    }
}
