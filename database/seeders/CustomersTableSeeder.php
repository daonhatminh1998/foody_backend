<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers =[
            ['Cus_Name'=> 'Dao Nhat Minh','Cus_Email'=>'daonhatminh30@gmail.com','Cus_Phone'=>'0382300327'],
        ];

        foreach($customers as $row){
            DB::table('customers') -> insert($row);
        }
    }
}
