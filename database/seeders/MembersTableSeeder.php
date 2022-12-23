<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = [
                [
                    'name'=>'Minh',
                    'email'=>'member1@gmail.com',

                    'avatar'=> 'member-0.jpg',
                    'bgimg'=> 'bg-0.jpg',

                    'username'=>'member1',
                    'password'=>bcrypt('123456'),
                    // 'password'=>Hash::make('123456'),
                    'created_at'=>now(),
                ],
                [
                    'name'=>'Khanh',
                    'email'=>'member2@gmail.com',

                    'avatar'=> 'member-0.jpg',
                    'bgimg'=> 'bg-1.jpg',

                    'username'=>'member2',
                    'password'=>bcrypt('123456'),
                    'created_at'=>now(),
                ],
                [
                    'name'=>'Hoan',
                    'email'=>'member3@gmail.com',

                    'avatar'=> 'member-0.jpg',
                    'bgimg'=> 'bg-0.jpg',

                    'username'=>'member3',
                    'password'=>bcrypt('123456'),
                    'created_at'=>now(),
                ],
                [
                    'name'=>'Tu',
                    'email'=>'member4@gmail.com',

                    'avatar'=> 'member-0.jpg',
                    'bgimg'=> 'bg-1.jpg',

                    'username'=>'member4',
                    'password'=>bcrypt('123456'),
                    'created_at'=>now(),
                ],
                [
                    'name'=>'Khuyen',
                    'email'=>'member5@gmail.com',

                    'avatar'=> 'member-0.jpg',
                    'bgimg'=> 'bg-0.jpg',

                    'username'=>'member5',
                    'password'=>bcrypt('123456'),
                    'created_at'=>now(),
                ],
                [
                    'name'=>'Viet',
                    'email'=>'member6@gmail.com',
                    
                    'avatar'=> 'member-0.jpg',
                    'bgimg'=> 'bg-1.jpg',

                    'username'=>'member6',
                    'password'=>bcrypt('123456'),
                    'created_at'=>now(),
                    ],
    ];

        foreach($members as $row){
            DB::table('members') -> insert($row);
        }
    }
}
