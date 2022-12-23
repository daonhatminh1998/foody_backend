<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,

            CustomersTableSeeder::class,
            AddressTableSeeder::class,

            MembersTableSeeder::class,
            ReceiverTableSeeder::class,
            
            ProductsTableSeeder::class,
            ProductDetailTableSeeder::class,

            CartsTableSeeder::class,
            CartDetailTableSeeder::class,

            OrderMemTableSeeder::class,
            OrderMemDetailTableSeeder::class,

            OrderCusTableSeeder::class,
            OrderCusDetailTableSeeder::class,
           ]);
    }
}
