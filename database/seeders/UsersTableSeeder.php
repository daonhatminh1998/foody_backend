<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users') -> insert([
            'name'=>'Web Admin',
            'email'=>'admin@gmail.com',
            'phone'=>'0382300327',

            'avatar'=> 'admin-0.jpg',
            'bgimg'=> 'bg-0.jpg',

            'username'=>'admin',
            'password'=>bcrypt('123456'),
            'created_at'=>now(),
        ]);

        $users = [
            [
                'name'=>'Minh',
                'email'=>'admin1@gmail.com',
                'phone'=>'0382300321',

                'avatar'=> 'admin-0.jpg',
                'bgimg'=> 'bg-0.jpg',

                'username'=>'admin1',
                'password'=>bcrypt('123456'),
                'created_at'=>now(),
                ],
                [
                'name'=>'Khanh',
                'email'=>'admin2@gmail.com',
                'phone'=>'0382300322',

                'avatar'=> 'admin-0.jpg',
                'bgimg'=> 'bg-0.jpg',

                'username'=>'admin2',
                'password'=>bcrypt('123456'),
                'created_at'=>now(),
                ],
            [
                'name'=>'Hoan',
                'email'=>'admin3@gmail.com',
                'phone'=>'0382300323',

                'avatar'=> 'admin-0.jpg',
                'bgimg'=> 'bg-0.jpg',

                'username'=>'admin3',
                'password'=>bcrypt('123456'),
                'created_at'=>now(),
                ],
                [
                'name'=>'Tu',
                'email'=>'admin4@gmail.com',
                'phone'=>'0382300324',

                'avatar'=> 'admin-0.jpg',
                'bgimg'=> 'bg-0.jpg',

                'username'=>'admin4',
                'password'=>bcrypt('123456'),
                'created_at'=>now(),
                ],
                [
                'name'=>'Khuyen',
                'email'=>'admin5@gmail.com',
                'phone'=>'0382300325',

                'avatar'=> 'admin-0.jpg',
                'bgimg'=> 'bg-0.jpg',

                'username'=>'admin5',
                'password'=>bcrypt('123456'),
                'created_at'=>now(),
                ],
                [
                'name'=>'Viet',
                'email'=>'admin6@gmail.com',
                'phone'=>'0382300326',

                'avatar'=> 'admin-0.jpg',
                'bgimg'=> 'bg-0.jpg',
                
                'username'=>'admin6',
                'password'=>bcrypt('123456'),
                'created_at'=>now(),
                ],
    ];

        foreach($users as $row){
            DB::table('users') -> insert($row);
        }
    }
}
