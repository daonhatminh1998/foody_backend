<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address =[
            ['is_Published'=>false,'Cus_Id'=>'1','Address'=> '254/19A Đường Lê Văn Thọ Phường 11, Quận Gò Vấp'],
            ['Cus_Id'=>'1','Address'=> '87 Đường số 2 KDC Cityland Park Hills Phường 10, Quận Gò Vấp'],
        ];

        foreach($address as $row){
            DB::table('address') -> insert($row);
        }
    }
}
