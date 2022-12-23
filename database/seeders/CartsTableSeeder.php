<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carts =[
            ['Mem_Id'=>'1'],
            ['Mem_Id'=>'2'],
            ['Mem_Id'=>'3'],
            ['Mem_Id'=>'4'],
            ['Mem_Id'=>'5'],
            ['Mem_Id'=>'6'],
        ];

        foreach($carts as $row){
            DB::table('carts') -> insert($row);
        }
    }
}
