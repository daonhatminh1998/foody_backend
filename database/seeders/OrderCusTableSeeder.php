<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderCusTableSeeder extends Seeder
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
           
            'ORD_Code'=>date('ymd\0\0\0\1'),

            "ORD_Name"=>'Đào Trúc Mai',
            "ORD_Phone"=>'0382300327',
            'ORD_Address'=>'254/19A Lê Văn Thọ Phường 11, Quận Gò Vấp',
            'ORD_Email'=>'daonhatminh@gmail.com',
            
            'ORD_CusNote'=>'czccxccccccccccccc',
            'ORD_AdNote'=>'2dsf',
        
            'Cus_Id'=>'1',
        ],

            
           
        ];

        foreach($orders as $row){
            DB::table('order_cus') -> insert($row);
        }
    }
}
