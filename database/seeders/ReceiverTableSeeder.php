<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiverTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $receiver = [
            ['name'=>'Dao Nhat Minh', 'phone'=>'0382300311', 'address'=>'254/19A Đường Lê Văn Thọ Phường 11, Quận Gò Vấp', 'Mem_Id'=>'1'],
            ['name'=>'Dao Nhat Minh', 'phone'=>'0382300311', 'address'=>'254/19A Đường Lê Văn Thọ Phường 11, Quận Gò Vấp', 'Mem_Id'=>'2','is_Default'=>1,'is_Chosen'=>1],
            ['name'=>'Dao Nhat Minh', 'phone'=>'0382300311', 'address'=>'254/19A Đường Lê Văn Thọ Phường 11, Quận Gò Vấp', 'Mem_Id'=>'3','is_Default'=>1,'is_Chosen'=>1],
            ['name'=>'Dao Nhat Minh', 'phone'=>'0382300311', 'address'=>'254/19A Đường Lê Văn Thọ Phường 11, Quận Gò Vấp', 'Mem_Id'=>'4','is_Default'=>1,'is_Chosen'=>1],
            ['name'=>'Dao Nhat Minh', 'phone'=>'0382300311', 'address'=>'254/19A Đường Lê Văn Thọ Phường 11, Quận Gò Vấp', 'Mem_Id'=>'5','is_Default'=>1],
            ['name'=>'Dao Nhat Minh', 'phone'=>'0382300311', 'address'=>'254/19A Đường Lê Văn Thọ Phường 11, Quận Gò Vấp', 'Mem_Id'=>'6','is_Default'=>1,'is_Chosen'=>1],

            ['name'=>'Huynh Ngoc Tu', 'phone'=>'0382300312', 'address'=>'87 Đường số 2 KDC Cityland Park Hills Phường 10, Quận Gò Vấp', 'Mem_Id'=>'1'],
            ['name'=>'Huynh Viet Khanh', 'phone'=>'0382300313', 'address'=>'87 Đường số 2 KDC Cityland Park Hills Phường 10, Quận Gò Vấp', 'Mem_Id'=>'2'],
            ['name'=>'Huynh Ngoc Tu', 'phone'=>'0382300314', 'address'=>'87 Đường số 2 KDC Cityland Park Hills Phường 10, Quận Gò Vấp', 'Mem_Id'=>'3'],

            ['name'=>'Dao Truc Mai', 'phone'=>'0382310312', 'address'=>'78/37/18 Đường Thống Nhất, Phường 11, Quận Gò Vấp', 'Mem_Id'=>'1','is_Default'=>1,'is_Chosen'=>1],


        ];
        foreach($receiver as $row){
            DB::table('receiver') -> insert($row);
        }
    }
}
